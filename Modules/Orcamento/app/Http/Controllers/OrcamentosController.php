<?php

namespace Modules\Orcamento\Http\Controllers;

use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Modules\Cadastros\Models\Clientes;
use Modules\Cadastros\Models\Produtos;
use Modules\Orcamento\Http\Requests\StoreOrcamentoRequest;
use Modules\Orcamento\Http\Requests\UpdateCabecalhoOrcamentoRequest;
use Modules\Orcamento\Http\Requests\UpdateOrcamentoRequest;
use Modules\Orcamento\Models\Orcamento;
use Modules\Orcamento\Models\OrcamentoCabecalho;

class OrcamentosController extends Controller
{
    private const STATUS_TRANSITIONS = [
        'Rascunho' => ['Enviado', 'Aprovado', 'Rejeitado', 'Expirado'],
        'Enviado' => ['Aprovado', 'Rejeitado', 'Expirado'],
        'Aprovado' => ['Expirado'],
        'Rejeitado' => ['Rascunho', 'Enviado'],
        'Expirado' => ['Rascunho', 'Enviado'],
    ];

    public function index(Request $request): View
    {
        $busca = (string) $request->input('busca', '');
        $status = (string) $request->input('status', '');
        $clienteId = (int) $request->input('cli_id', 0);
        $dataInicio = (string) $request->input('data_inicio', '');
        $dataFim = (string) $request->input('data_fim', '');
        $dataValidadeInicio = (string) $request->input('data_validade_inicio', '');
        $dataValidadeFim = (string) $request->input('data_validade_fim', '');
        $statusOpcoes = array_keys(self::STATUS_TRANSITIONS);
        $clientesFiltro = Clientes::query()
            ->where('cli_ativo', 1)
            ->orderBy('cli_nome')
            ->get(['cli_id', 'cli_nome']);

        $orcamentos = Orcamento::query()
            ->with('cliente')
            ->when($busca !== '', function ($query) use ($busca) {
                $query->where('orc_numero', 'like', "%{$busca}%")
                    ->orWhereHas('cliente', function ($subQuery) use ($busca) {
                        $subQuery->where('cli_nome', 'like', "%{$busca}%");
                    });
            })
            ->when(in_array($status, $statusOpcoes, true), function ($query) use ($status) {
                $query->where('orc_status', $status);
            })
            ->when($clienteId > 0, function ($query) use ($clienteId) {
                $query->where('cli_id', $clienteId);
            })
            ->when($dataInicio !== '', function ($query) use ($dataInicio) {
                $query->whereDate('orc_data_emissao', '>=', $dataInicio);
            })
            ->when($dataFim !== '', function ($query) use ($dataFim) {
                $query->whereDate('orc_data_emissao', '<=', $dataFim);
            })
            ->when($dataValidadeInicio !== '', function ($query) use ($dataValidadeInicio) {
                $query->whereDate('orc_data_validade', '>=', $dataValidadeInicio);
            })
            ->when($dataValidadeFim !== '', function ($query) use ($dataValidadeFim) {
                $query->whereDate('orc_data_validade', '<=', $dataValidadeFim);
            })
            ->orderByDesc('orc_id')
            ->paginate(15)
            ->withQueryString();

        return view('orcamento::orcamentos.index', [
            'orcamentos' => $orcamentos,
            'busca' => $busca,
            'filtros' => [
                'status' => $status,
                'cli_id' => $clienteId,
                'data_inicio' => $dataInicio,
                'data_fim' => $dataFim,
                'data_validade_inicio' => $dataValidadeInicio,
                'data_validade_fim' => $dataValidadeFim,
            ],
            'statusOpcoes' => $statusOpcoes,
            'clientesFiltro' => $clientesFiltro,
        ]);
    }

    public function create(): View
    {
        [$clientes, $produtos] = $this->carregarDadosFormulario();

        return view('orcamento::orcamentos.create', [
            'clientes' => $clientes,
            'produtos' => $produtos,
            'dataCriacaoPadrao' => now()->format('Y-m-d'),
            'dataValidadePadrao' => now()->addDays(15)->format('Y-m-d'),
            'itensIniciais' => [],
            'orcamento' => null,
        ]);
    }

    public function edit(int $id): View
    {
        $orcamento = Orcamento::query()->with('itens')->findOrFail($id);

        [$clientes, $produtos] = $this->carregarDadosFormulario();

        $itensIniciais = $orcamento->itens->map(function ($item) {
            return [
                'prod_id' => $item->prod_id,
                'produto_label' => $item->oci_produto_codigo.' - '.$item->oci_produto_nome,
                'oci_quantidade' => (string) ((float) $item->oci_quantidade),
                'oci_valor_unitario' => number_format((float) $item->oci_valor_unitario, 2, ',', '.'),
            ];
        })->values();

        return view('orcamento::orcamentos.create', [
            'clientes' => $clientes,
            'produtos' => $produtos,
            'dataCriacaoPadrao' => $orcamento->orc_data_emissao?->format('Y-m-d'),
            'dataValidadePadrao' => $orcamento->orc_data_validade?->format('Y-m-d'),
            'itensIniciais' => $itensIniciais,
            'orcamento' => $orcamento,
        ]);
    }

    public function store(StoreOrcamentoRequest $request): RedirectResponse
    {
        $dados = $request->validated();

        $orcamento = DB::transaction(function () use ($dados) {
            [$itens, $subtotal] = $this->prepararItens($dados['itens']);

            $descontoPercentual = $this->normalizarDecimal((string) ($dados['orc_desconto_percentual'] ?? '0'));
            $descontoPercentual = min(max($descontoPercentual, 0), 100);

            $valorDesconto = round(($subtotal * $descontoPercentual) / 100, 2);
            $total = round($subtotal - $valorDesconto, 2);

            $orcamento = Orcamento::query()->create([
                'orc_numero' => $this->gerarNumero(),
                'cli_id' => (int) $dados['cli_id'],
                'orc_data_emissao' => $dados['orc_data_emissao'],
                'orc_data_validade' => $dados['orc_data_validade'],
                'orc_desconto_percentual' => $descontoPercentual,
                'orc_subtotal' => $subtotal,
                'orc_valor_desconto' => $valorDesconto,
                'orc_total' => $total,
                'orc_status' => 'Rascunho',
                'orc_observacoes' => $dados['orc_observacoes'] ?? null,
            ]);

            $orcamento->itens()->createMany($itens);

            $this->registrarHistoricoStatus($orcamento, null, 'Rascunho', 'Orcamento criado.');

            return $orcamento;
        });

        return redirect()->route('orcamento::orcamentos.show', $orcamento->orc_id)->with('message', [
            'type' => 'success',
            'text' => 'Orcamento criado com sucesso.',
        ]);
    }

    public function update(UpdateOrcamentoRequest $request, int $id): RedirectResponse
    {
        $orcamento = Orcamento::query()->with('itens')->findOrFail($id);
        $dados = $request->validated();

        DB::transaction(function () use ($orcamento, $dados) {
            [$itens, $subtotal] = $this->prepararItens($dados['itens']);

            $descontoPercentual = $this->normalizarDecimal((string) ($dados['orc_desconto_percentual'] ?? '0'));
            $descontoPercentual = min(max($descontoPercentual, 0), 100);

            $valorDesconto = round(($subtotal * $descontoPercentual) / 100, 2);
            $total = round($subtotal - $valorDesconto, 2);

            $orcamento->update([
                'cli_id' => (int) $dados['cli_id'],
                'orc_data_emissao' => $dados['orc_data_emissao'],
                'orc_data_validade' => $dados['orc_data_validade'],
                'orc_desconto_percentual' => $descontoPercentual,
                'orc_subtotal' => $subtotal,
                'orc_valor_desconto' => $valorDesconto,
                'orc_total' => $total,
                'orc_observacoes' => $dados['orc_observacoes'] ?? null,
            ]);

            $orcamento->itens()->delete();
            $orcamento->itens()->createMany($itens);
        });

        return redirect()->route('orcamento::orcamentos.show', $orcamento->orc_id)->with('message', [
            'type' => 'success',
            'text' => 'Orcamento atualizado com sucesso.',
        ]);
    }

    public function updateStatus(Request $request, int $id): RedirectResponse
    {
        $dados = $request->validate([
            'orc_status' => ['required', 'in:Rascunho,Enviado,Aprovado,Rejeitado,Expirado'],
            'motivo_status' => ['nullable', 'string', 'max:500'],
        ]);

        $orcamento = Orcamento::query()->findOrFail($id);
        $this->alterarStatusOrcamento($orcamento, $dados['orc_status'], $dados['motivo_status'] ?? null);

        return back()->with('message', [
            'type' => 'success',
            'text' => 'Status do orcamento atualizado para '.$dados['orc_status'].'.',
        ]);
    }

    public function show(int $id): View
    {
        $orcamento = Orcamento::query()->with(['cliente', 'itens', 'historicoStatus.usuario'])->findOrFail($id);

        return view('orcamento::orcamentos.show', [
            'orcamento' => $orcamento,
            'cabecalho' => OrcamentoCabecalho::query()->first(),
            'statusPermitidos' => $this->statusPermitidos((string) $orcamento->orc_status),
        ]);
    }

    public function duplicate(int $id): RedirectResponse
    {
        $origem = Orcamento::query()->with('itens')->findOrFail($id);

        $orcamentoDuplicado = DB::transaction(function () use ($origem) {
            $novo = Orcamento::query()->create([
                'orc_numero' => $this->gerarNumero(),
                'cli_id' => $origem->cli_id,
                'orc_data_emissao' => now()->toDateString(),
                'orc_data_validade' => now()->addDays(15)->toDateString(),
                'orc_desconto_percentual' => $origem->orc_desconto_percentual,
                'orc_subtotal' => $origem->orc_subtotal,
                'orc_valor_desconto' => $origem->orc_valor_desconto,
                'orc_total' => $origem->orc_total,
                'orc_status' => 'Rascunho',
                'orc_observacoes' => $origem->orc_observacoes,
            ]);

            $itens = $origem->itens->map(function ($item) {
                return [
                    'prod_id' => $item->prod_id,
                    'oci_produto_codigo' => $item->oci_produto_codigo,
                    'oci_produto_nome' => $item->oci_produto_nome,
                    'oci_quantidade' => $item->oci_quantidade,
                    'oci_valor_unitario' => $item->oci_valor_unitario,
                    'oci_total' => $item->oci_total,
                ];
            })->values()->all();

            $novo->itens()->createMany($itens);
            $this->registrarHistoricoStatus($novo, null, 'Rascunho', 'Orcamento duplicado de '.$origem->orc_numero.'.');

            return $novo;
        });

        return redirect()->route('orcamento::orcamentos.edit', $orcamentoDuplicado->orc_id)->with('message', [
            'type' => 'success',
            'text' => 'Orcamento duplicado com sucesso. Revise os dados antes de salvar.',
        ]);
    }

    public function destroy(int $id): RedirectResponse
    {
        $orcamento = Orcamento::query()->findOrFail($id);
        $orcamento->delete();

        return redirect()->route('orcamento::orcamentos.index')->with('message', [
            'type' => 'success',
            'text' => 'Orcamento excluido com sucesso.',
        ]);
    }

    public function previewPdf(int $id)
    {
        $orcamento = Orcamento::query()->with(['cliente', 'itens'])->findOrFail($id);

        return $this->buildPdf($orcamento)->stream("orcamento-{$orcamento->orc_numero}.pdf");
    }

    public function downloadPdf(int $id)
    {
        $orcamento = Orcamento::query()->with(['cliente', 'itens'])->findOrFail($id);

        return $this->buildPdf($orcamento)->download("orcamento-{$orcamento->orc_numero}.pdf");
    }

    public function publicPdf(Request $request, int $id)
    {
        $orcamento = Orcamento::query()->with(['cliente', 'itens'])->findOrFail($id);

        return $this->buildPdf($orcamento)->stream("orcamento-{$orcamento->orc_numero}.pdf");
    }

    public function sendEmail(Request $request, int $id): RedirectResponse
    {
        $dados = $request->validate([
            'email_destino' => ['nullable', 'email', 'max:255'],
            'assunto' => ['nullable', 'string', 'max:120'],
            'mensagem' => ['nullable', 'string', 'max:2000'],
        ]);

        $orcamento = Orcamento::query()->with(['cliente', 'itens'])->findOrFail($id);

        $destino = $dados['email_destino'] ?? $orcamento->cliente?->cli_email;

        if (! $destino) {
            return back()->with('message', [
                'type' => 'danger',
                'text' => 'Informe um e-mail de destino.',
            ]);
        }

        $pdf = $this->buildPdf($orcamento)->output();
        $assunto = $dados['assunto'] ?? "Orcamento {$orcamento->orc_numero}";
        $mensagem = $dados['mensagem'] ?? "Segue em anexo o orcamento {$orcamento->orc_numero}.";

        Mail::send([], [], function ($mail) use ($destino, $assunto, $mensagem, $pdf, $orcamento) {
            $mail->to($destino)
                ->subject($assunto)
                ->text($mensagem)
                ->attachData($pdf, "orcamento-{$orcamento->orc_numero}.pdf", [
                    'mime' => 'application/pdf',
                ]);
        });

        $this->alterarStatusOrcamento($orcamento, 'Enviado', 'Envio de orcamento por e-mail.', false);

        return back()->with('message', [
            'type' => 'success',
            'text' => 'Orcamento enviado por e-mail com sucesso.',
        ]);
    }

    public function redirectWhatsapp(int $id)
    {
        $orcamento = Orcamento::query()->with(['cliente', 'itens'])->findOrFail($id);

        $telefone = $orcamento->cliente?->cli_celular ?: $orcamento->cliente?->cli_telefone;
        $telefone = preg_replace('/\D/', '', (string) $telefone);

        if (! $telefone) {
            return back()->with('message', [
                'type' => 'danger',
                'text' => 'Cliente sem telefone ou celular para envio via WhatsApp.',
            ]);
        }

        $urlPublica = URL::temporarySignedRoute('orcamento::orcamentos.public-pdf', now()->addDays(15), [
            'id' => $orcamento->orc_id,
        ]);

        $mensagem = "Olá, segue o orçamento {$orcamento->orc_numero} no valor de {$this->formatarMoeda((float) $orcamento->orc_total)}. Link para visualização: {$urlPublica}";

        $url = 'https://wa.me/'.$telefone.'?text='.rawurlencode($mensagem);

        $this->alterarStatusOrcamento($orcamento, 'Enviado', 'Envio de orcamento por WhatsApp.', false);

        return redirect()->away($url);
    }

    public function headerConfig(): View
    {
        return view('orcamento::orcamentos.header-config', [
            'cabecalho' => OrcamentoCabecalho::query()->first(),
        ]);
    }

    public function saveHeaderConfig(UpdateCabecalhoOrcamentoRequest $request): RedirectResponse
    {
        $cabecalho = OrcamentoCabecalho::query()->first();

        if (! $cabecalho) {
            $cabecalho = new OrcamentoCabecalho;
        }

        $cabecalho->fill($request->validated());
        $cabecalho->save();

        return redirect()->route('orcamento::orcamentos.header-config')->with('message', [
            'type' => 'success',
            'text' => 'Cabecalho do PDF atualizado com sucesso.',
        ]);
    }

    private function prepararItens(array $itens): array
    {
        $subtotal = 0.0;
        $itensPreparados = [];
        $produtosJaSelecionados = [];

        foreach ($itens as $indice => $item) {
            $produtoId = (int) ($item['prod_id'] ?? 0);

            if (in_array($produtoId, $produtosJaSelecionados, true)) {
                throw ValidationException::withMessages([
                    "itens.{$indice}.prod_id" => 'Nao repita o mesmo produto em mais de uma linha do orçamento.',
                ]);
            }

            $produto = Produtos::query()->findOrFail($produtoId);
            $produtosJaSelecionados[] = $produtoId;

            $quantidade = $this->normalizarDecimal((string) $item['oci_quantidade']);
            $valorUnitario = $this->normalizarDecimal((string) $item['oci_valor_unitario']);
            $total = round($quantidade * $valorUnitario, 2);

            $subtotal += $total;

            $itensPreparados[] = [
                'prod_id' => $produto->prod_id,
                'oci_produto_codigo' => (string) $produto->prod_codigo,
                'oci_produto_nome' => (string) $produto->prod_nome,
                'oci_quantidade' => $quantidade,
                'oci_valor_unitario' => $valorUnitario,
                'oci_total' => $total,
            ];
        }

        return [$itensPreparados, round($subtotal, 2)];
    }

    private function carregarDadosFormulario(): array
    {
        $clientes = Clientes::query()
            ->where('cli_ativo', 1)
            ->orderBy('cli_nome')
            ->get(['cli_id', 'cli_nome', 'cli_email', 'cli_telefone', 'cli_celular']);

        $produtos = Produtos::query()
            ->where('prod_ativo', 1)
            ->orderBy('prod_nome')
            ->get(['prod_id', 'prod_codigo', 'prod_nome', 'prod_valor']);

        return [$clientes, $produtos];
    }

    private function statusPermitidos(string $statusAtual): array
    {
        $transicoes = self::STATUS_TRANSITIONS[$statusAtual] ?? [];

        return [$statusAtual, ...$transicoes];
    }

    private function isTransicaoPermitida(string $statusAtual, string $novoStatus): bool
    {
        if ($statusAtual === $novoStatus) {
            return true;
        }

        return in_array($novoStatus, self::STATUS_TRANSITIONS[$statusAtual] ?? [], true);
    }

    private function alterarStatusOrcamento(Orcamento $orcamento, string $novoStatus, ?string $motivo = null, bool $validarTransicao = true): void
    {
        $statusAtual = (string) $orcamento->orc_status;

        if ($validarTransicao && ! $this->isTransicaoPermitida($statusAtual, $novoStatus)) {
            throw ValidationException::withMessages([
                'orc_status' => ["Transicao de status invalida: {$statusAtual} para {$novoStatus}."],
            ]);
        }

        if ($statusAtual === $novoStatus) {
            return;
        }

        $orcamento->update([
            'orc_status' => $novoStatus,
        ]);

        $this->registrarHistoricoStatus($orcamento, $statusAtual, $novoStatus, $motivo);
    }

    private function registrarHistoricoStatus(Orcamento $orcamento, ?string $statusAnterior, string $novoStatus, ?string $motivo = null): void
    {
        $usuarioId = Auth::user()?->usr_id;

        DB::table('orc_status_historicos')->insert([
            'orc_id' => $orcamento->orc_id,
            'usr_id' => $usuarioId,
            'osh_status_anterior' => $statusAnterior,
            'osh_status_novo' => $novoStatus,
            'osh_motivo' => $motivo,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    private function gerarNumero(): string
    {
        $proximo = ((int) Orcamento::query()->max('orc_id')) + 1;

        return 'ORC-'.now()->format('Y').'-'.str_pad((string) $proximo, 6, '0', STR_PAD_LEFT);
    }

    private function normalizarDecimal(string $valor): float
    {
        $valor = trim($valor);

        if (str_contains($valor, ',') && str_contains($valor, '.')) {
            $valor = str_replace('.', '', $valor);
            $valor = str_replace(',', '.', $valor);
        } elseif (str_contains($valor, ',')) {
            $valor = str_replace(',', '.', $valor);
        }

        return (float) $valor;
    }

    private function formatarMoeda(float $valor): string
    {
        return 'R$ '.number_format($valor, 2, ',', '.');
    }

    private function buildPdf(Orcamento $orcamento)
    {
        return Pdf::loadView('orcamento::pdf.orcamento', [
            'orcamento' => $orcamento,
            'cabecalho' => OrcamentoCabecalho::query()->first(),
        ]);
    }
}
