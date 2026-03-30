<?php

namespace Modules\Relatorios\Http\Controllers;

use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Modules\Base\Http\Controllers\BaseController;
use Modules\Producao\Models\Producoes;

class RelatoriosController extends Controller
{
    protected function getRange(Request $request): array
    {
        $inicio = $request->input('start_date');
        $fim = $request->input('end_date');

        $dataInicio = $inicio ? Carbon::parse($inicio)->startOfDay() : Carbon::now()->startOfMonth();
        $dataFim = $fim ? Carbon::parse($fim)->endOfDay() : Carbon::now()->endOfDay();

        return [$dataInicio, $dataFim];
    }

    public function index()
    {
        return view('relatorios::index');
    }

    public function productionDaily(Request $request)
    {
        [$dataInicio, $dataFim] = $this->getRange($request);

        $registros = Producoes::query()
            ->select([
                'pro_producoes.produ_data',
                'pro_producoes.produ_hora',
                'cad_funcionarios.fun_nome as funcionario_nome',
                'cad_produtos.prod_nome as produto_nome',
                'pro_producoes.produ_quantidade',
                'pro_producoes.produ_tempo_gasto',
            ])
            ->join('cad_funcionarios', 'cad_funcionarios.fun_id', '=', 'pro_producoes.fun_id')
            ->join('cad_produtos', 'cad_produtos.prod_id', '=', 'pro_producoes.prod_id')
            ->whereBetween('pro_producoes.produ_data', [$dataInicio, $dataFim])
            ->orderBy('pro_producoes.produ_data', 'desc')
            ->orderBy('pro_producoes.produ_hora', 'desc')
            ->get();

        $quantidadeTotal = $registros->sum('produ_quantidade');
        $tempoTotal = $registros->sum('produ_tempo_gasto');

        if ($request->input('export') === 'excel') {
            $cabecalhos = ['Data', 'Hora', 'Funcionário', 'Produto', 'Quantidade', 'Tempo gasto'];
            $dados = $registros->map(function ($registro) {
                return [
                    $registro->produ_data->format('d/m/Y'),
                    $registro->produ_hora,
                    $registro->funcionario_nome,
                    $registro->produto_nome,
                    $registro->produ_quantidade,
                    $registro->produ_tempo_gasto ? gmdate('H:i:s', $registro->produ_tempo_gasto) : '',
                ];
            })->toArray();

            return $this->downloadCsv($cabecalhos, $dados, 'relatorio-producao-diaria.csv');
        }

        if ($request->input('export') === 'pdf') {
            return $this->downloadPdf(
                'Relatório de Produção Diária',
                "Período: {$dataInicio->format('d/m/Y')} até {$dataFim->format('d/m/Y')}",
                ['Data', 'Hora', 'Funcionário', 'Produto', 'Quantidade', 'Tempo gasto'],
                $registros->map(function ($registro) {
                    return [
                        $registro->produ_data->format('d/m/Y'),
                        $registro->produ_hora,
                        $registro->funcionario_nome,
                        $registro->produto_nome,
                        $registro->produ_quantidade,
                        $registro->produ_tempo_gasto ? gmdate('H:i:s', $registro->produ_tempo_gasto) : '',
                    ];
                })->toArray(),
                'relatorio-producao-diaria.pdf'
            );
        }

        return view('relatorios::production_daily', [
            'dataInicio' => $dataInicio,
            'dataFim' => $dataFim,
            'registros' => $registros,
            'quantidadeTotal' => $quantidadeTotal,
            'tempoTotal' => $tempoTotal,
        ]);
    }

    public function productivityEmployee(Request $request)
    {
        [$dataInicio, $dataFim] = $this->getRange($request);

        $registros = Producoes::query()
            ->selectRaw(
                'pro_producoes.fun_id, cad_funcionarios.fun_nome as funcionario_nome, SUM(pro_producoes.produ_quantidade) as quantidade_total, SUM(pro_producoes.produ_tempo_gasto) as tempo_total'
            )
            ->join('cad_funcionarios', 'cad_funcionarios.fun_id', '=', 'pro_producoes.fun_id')
            ->whereBetween('pro_producoes.produ_data', [$dataInicio, $dataFim])
            ->groupBy('pro_producoes.fun_id', 'cad_funcionarios.fun_nome')
            ->orderByDesc('quantidade_total')
            ->get()
            ->map(function ($item) {
                $item->tempo_medio_segundos = $item->quantidade_total ? round($item->tempo_total / $item->quantidade_total) : 0;
                $item->pecas_por_hora = $item->tempo_total ? round($item->quantidade_total / ($item->tempo_total / 3600), 2) : 0;
                return $item;
            });

        if ($request->input('export') === 'excel') {
            $cabecalhos = ['Funcionário', 'Quantidade', 'Tempo total', 'Tempo médio/peça', 'Peças/h'];
            $dados = $registros->map(function ($item) {
                return [
                    $item->funcionario_nome,
                    $item->quantidade_total,
                    $item->tempo_total ? gmdate('H:i:s', $item->tempo_total) : '',
                    $item->tempo_medio_segundos ? gmdate('H:i:s', $item->tempo_medio_segundos) : '',
                    $item->pecas_por_hora,
                ];
            })->toArray();

            return $this->downloadCsv($cabecalhos, $dados, 'relatorio-produtividade-funcionario.csv');
        }

        if ($request->input('export') === 'pdf') {
            return $this->downloadPdf(
                'Relatório de Produtividade por Funcionário',
                "Período: {$dataInicio->format('d/m/Y')} até {$dataFim->format('d/m/Y')}",
                ['Funcionário', 'Quantidade', 'Tempo total', 'Tempo médio/peça', 'Peças/h'],
                $registros->map(function ($item) {
                    return [
                        $item->funcionario_nome,
                        $item->quantidade_total,
                        $item->tempo_total ? gmdate('H:i:s', $item->tempo_total) : '',
                        $item->tempo_medio_segundos ? gmdate('H:i:s', $item->tempo_medio_segundos) : '',
                        $item->pecas_por_hora,
                    ];
                })->toArray(),
                'relatorio-produtividade-funcionario.pdf'
            );
        }

        return view('relatorios::productivity_employee', [
            'dataInicio' => $dataInicio,
            'dataFim' => $dataFim,
            'registros' => $registros,
        ]);
    }

    public function productionProduct(Request $request)
    {
        [$dataInicio, $dataFim] = $this->getRange($request);

        $registros = Producoes::query()
            ->selectRaw(
                'pro_producoes.prod_id, cad_produtos.prod_nome as produto_nome, SUM(pro_producoes.produ_quantidade) as quantidade_total, SUM(pro_producoes.produ_tempo_gasto) as tempo_total'
            )
            ->join('cad_produtos', 'cad_produtos.prod_id', '=', 'pro_producoes.prod_id')
            ->whereBetween('pro_producoes.produ_data', [$dataInicio, $dataFim])
            ->groupBy('pro_producoes.prod_id', 'cad_produtos.prod_nome')
            ->orderByDesc('quantidade_total')
            ->get()
            ->map(function ($item) {
                $item->tempo_medio_segundos = $item->quantidade_total ? round($item->tempo_total / $item->quantidade_total) : 0;
                return $item;
            });

        if ($request->input('export') === 'excel') {
            $cabecalhos = ['Produto', 'Quantidade', 'Tempo total', 'Tempo médio/peça'];
            $dados = $registros->map(function ($item) {
                return [
                    $item->produto_nome,
                    $item->quantidade_total,
                    $item->tempo_total ? gmdate('H:i:s', $item->tempo_total) : '',
                    $item->tempo_medio_segundos ? gmdate('H:i:s', $item->tempo_medio_segundos) : '',
                ];
            })->toArray();

            return $this->downloadCsv($cabecalhos, $dados, 'relatorio-producao-produto.csv');
        }

        if ($request->input('export') === 'pdf') {
            return $this->downloadPdf(
                'Relatório de Produção por Produto',
                "Período: {$dataInicio->format('d/m/Y')} até {$dataFim->format('d/m/Y')}",
                ['Produto', 'Quantidade', 'Tempo total', 'Tempo médio/peça'],
                $registros->map(function ($item) {
                    return [
                        $item->produto_nome,
                        $item->quantidade_total,
                        $item->tempo_total ? gmdate('H:i:s', $item->tempo_total) : '',
                        $item->tempo_medio_segundos ? gmdate('H:i:s', $item->tempo_medio_segundos) : '',
                    ];
                })->toArray(),
                'relatorio-producao-produto.pdf'
            );
        }

        return view('relatorios::production_product', [
            'dataInicio' => $dataInicio,
            'dataFim' => $dataFim,
            'registros' => $registros,
        ]);
    }

    public function comparison(Request $request)
    {
        $hoje = Carbon::today();
        $inicioSemanaAtual = $hoje->copy()->startOfWeek();
        $inicioSemanaAnterior = $inicioSemanaAtual->copy()->subWeek();
        $fimSemanaAnterior = $inicioSemanaAtual->copy()->subDay();

        $inicioMesAtual = $hoje->copy()->startOfMonth();
        $inicioMesAnterior = $inicioMesAtual->copy()->subMonth();
        $fimMesAnterior = $inicioMesAtual->copy()->subDay();

        $semanaAtual = $this->sumRange($inicioSemanaAtual, $hoje);
        $semanaAnterior = $this->sumRange($inicioSemanaAnterior, $fimSemanaAnterior);
        $mesAtual = $this->sumRange($inicioMesAtual, $hoje);
        $mesAnterior = $this->sumRange($inicioMesAnterior, $fimMesAnterior);

        $ultimos14Dias = Producoes::query()
            ->selectRaw('produ_data as date, SUM(produ_quantidade) as total_quantity')
            ->whereBetween('produ_data', [$hoje->copy()->subDays(13), $hoje])
            ->groupBy('produ_data')
            ->orderBy('produ_data')
            ->get()
            ->mapWithKeys(fn ($item) => [$item->date => $item->total_quantity]);

        $rotulosDiarios = [];
        $valoresDiarios = [];
        for ($date = $hoje->copy()->subDays(13); $date->lte($hoje); $date->addDay()) {
            $rotulosDiarios[] = $date->format('d/m');
            $valoresDiarios[] = $ultimos14Dias->get($date->format('Y-m-d'), 0);
        }

        if ($request->input('export') === 'excel') {
            $cabecalhos = ['Período', 'Quantidade'];
            $dados = [
                ['Semana atual', $semanaAtual],
                ['Semana anterior', $semanaAnterior],
                ['Mês atual', $mesAtual],
                ['Mês anterior', $mesAnterior],
            ];

            return $this->downloadCsv($cabecalhos, $dados, 'relatorio-comparativo.csv');
        }

        if ($request->input('export') === 'pdf') {
            return $this->downloadPdf(
                'Relatório Comparativo',
                'Comparação de períodos padrão',
                ['Período', 'Quantidade'],
                [
                    ['Semana atual', $semanaAtual],
                    ['Semana anterior', $semanaAnterior],
                    ['Mês atual', $mesAtual],
                    ['Mês anterior', $mesAnterior],
                ],
                'relatorio-comparativo.pdf'
            );
        }

        return view('relatorios::comparison', [
            'semanaAtual' => $semanaAtual,
            'semanaAnterior' => $semanaAnterior,
            'mesAtual' => $mesAtual,
            'mesAnterior' => $mesAnterior,
            'rotulosDiarios' => $rotulosDiarios,
            'valoresDiarios' => $valoresDiarios,
        ]);
    }

    public function projection(Request $request)
    {
        $hoje = Carbon::today();
        $inicioMesAtual = $hoje->copy()->startOfMonth();
        $fimMesAtual = $hoje->copy()->endOfMonth();
        $totalMes = $this->sumRange($inicioMesAtual, $hoje);
        $diasDecorridos = $hoje->day;
        $diasRestantes = $hoje->diffInDays($fimMesAtual);
        $mediaDiaria = $diasDecorridos ? round($totalMes / $diasDecorridos, 2) : 0;
        $projecao = round($totalMes + ($mediaDiaria * $diasRestantes));

        $melhoresFuncionarios = Producoes::query()
            ->selectRaw('pro_producoes.fun_id, cad_funcionarios.fun_nome as funcionario_nome, SUM(produ_quantidade) as quantidade_total')
            ->join('cad_funcionarios', 'cad_funcionarios.fun_id', '=', 'pro_producoes.fun_id')
            ->whereBetween('pro_producoes.produ_data', [$inicioMesAtual, $hoje])
            ->groupBy('pro_producoes.fun_id', 'cad_funcionarios.fun_nome')
            ->orderByDesc('quantidade_total')
            ->limit(5)
            ->get();

        $melhoresProdutos = Producoes::query()
            ->selectRaw('pro_producoes.prod_id, cad_produtos.prod_nome as produto_nome, SUM(produ_quantidade) as quantidade_total')
            ->join('cad_produtos', 'cad_produtos.prod_id', '=', 'pro_producoes.prod_id')
            ->whereBetween('pro_producoes.produ_data', [$inicioMesAtual, $hoje])
            ->groupBy('pro_producoes.prod_id', 'cad_produtos.prod_nome')
            ->orderByDesc('quantidade_total')
            ->limit(5)
            ->get();

        if ($request->input('export') === 'excel') {
            $cabecalhos = ['Métrica', 'Valor'];
            $dados = [
                ['Total acumulado', $totalMes],
                ['Média diária', $mediaDiaria],
                ['Dias restantes', $diasRestantes],
                ['Projeção final de mês', $projecao],
            ];
            return $this->downloadCsv($cabecalhos, $dados, 'relatorio-projecao.csv');
        }

        if ($request->input('export') === 'pdf') {
            return $this->downloadPdf(
                'Relatório de Projeção',
                "Mês atual: {$inicioMesAtual->format('F/Y')}",
                ['Métrica', 'Valor'],
                [
                    ['Total acumulado', $totalMes],
                    ['Média diária', $mediaDiaria],
                    ['Dias restantes', $diasRestantes],
                    ['Projeção final de mês', $projecao],
                ],
                'relatorio-projecao.pdf'
            );
        }

        return view('relatorios::projection', [
            'totalMes' => $totalMes,
            'mediaDiaria' => $mediaDiaria,
            'diasRestantes' => $diasRestantes,
            'projecao' => $projecao,
            'melhoresFuncionarios' => $melhoresFuncionarios,
            'melhoresProdutos' => $melhoresProdutos,
        ]);
    }

    protected function sumRange(Carbon $inicio, Carbon $fim): int
    {
        return (int) Producoes::query()
            ->whereBetween('produ_data', [$inicio, $fim])
            ->sum('produ_quantidade');
    }

    protected function downloadCsv(array $cabecalhos, array $linhas, string $nomeArquivo)
    {
        $callback = function () use ($cabecalhos, $linhas) {
            $file = fopen('php://output', 'w');
            fwrite($file, "\xEF\xBB\xBF");
            fputcsv($file, $cabecalhos, ';');

            foreach ($linhas as $linha) {
                fputcsv($file, $linha, ';');
            }

            fclose($file);
        };

        return response()->streamDownload($callback, $nomeArquivo, [
            'Content-Type' => 'text/csv; charset=utf-8',
        ]);
    }

    protected function downloadPdf(string $title, string $subtitle, array $cabecalhos, array $linhas, string $nomeArquivo)
    {
        if (!class_exists(Pdf::class)) {
            abort(500, 'PDF export requires the package barryvdh/laravel-dompdf. Run composer require barryvdh/laravel-dompdf and install dependencies.');
        }

        $pdf = Pdf::loadView('relatorios::pdf.report', [
            'title' => $title,
            'subtitle' => $subtitle,
            'headers' => $cabecalhos,
            'linhas' => $linhas,
        ]);

        return $pdf->download($nomeArquivo);
    }
}
