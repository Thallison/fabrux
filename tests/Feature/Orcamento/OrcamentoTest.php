<?php

use Illuminate\Support\Facades\DB;
use Modules\Seguranca\Models\Usuarios;

function concederPermissoesOrcamentos(Usuarios $user): void
{
    $agora = now();

    $sisId = DB::table('seg_sistemas')->insertGetId([
        'sis_nome' => 'Sistema Orcamentos '.fake()->unique()->numerify('###'),
        'sis_icone' => 'bi bi-gear',
        'created_at' => $agora,
        'updated_at' => $agora,
    ]);

    $modId = DB::table('seg_modulos')->insertGetId([
        'sis_id' => $sisId,
        'mod_nome' => 'Modulo Orcamento '.fake()->unique()->numerify('###'),
        'mod_icone' => 'bi bi-receipt-cutoff',
        'created_at' => $agora,
        'updated_at' => $agora,
    ]);

    $funcId = DB::table('seg_funcionalidades')->insertGetId([
        'mod_id' => $modId,
        'func_id_pai' => null,
        'func_controller' => 'Modules\\Orcamento\\Http\\Controllers\\OrcamentosController',
        'func_label' => 'Orcamentos',
        'func_tipo' => 'Controller',
        'func_acesso_menu' => 1,
        'func_icon' => 'bi bi-circle',
        'func_rota_padrao' => 'orcamento::orcamentos.index',
        'created_at' => $agora,
        'updated_at' => $agora,
    ]);

    $papelId = DB::table('seg_papeis')->insertGetId([
        'papel_nome' => 'Papel Orcamentos '.fake()->unique()->numerify('###'),
        'created_at' => $agora,
        'updated_at' => $agora,
    ]);

    $actions = ['index', 'create', 'store', 'show', 'edit', 'update', 'duplicate', 'destroy', 'updateStatus'];

    foreach ($actions as $action) {
        $privId = DB::table('seg_privilegios')->insertGetId([
            'func_id' => $funcId,
            'priv_label' => 'Orcamentos '.strtoupper($action),
            'priv_action' => $action,
            'created_at' => $agora,
            'updated_at' => $agora,
        ]);

        DB::table('seg_privilegios_papeis')->insert([
            'priv_id' => $privId,
            'papel_id' => $papelId,
            'created_at' => $agora,
            'updated_at' => $agora,
        ]);
    }

    DB::table('seg_usuarios_papeis')->insert([
        'usr_id' => $user->usr_id,
        'papel_id' => $papelId,
        'created_at' => $agora,
        'updated_at' => $agora,
    ]);
}

function criarClienteOrcamento(?string $nome = null): int
{
    return DB::table('cad_clientes')->insertGetId([
        'cli_codigo' => 'CLI'.fake()->unique()->numerify('######'),
        'cli_nome' => $nome ?? 'Cliente Orcamento',
        'cli_tipo' => 'J',
        'cli_cpf_cnpj' => fake()->unique()->numerify('##############'),
        'cli_ie' => null,
        'cli_im' => null,
        'cli_logradouro' => 'Rua A',
        'cli_numero' => '10',
        'cli_complemento' => null,
        'cli_bairro' => 'Centro',
        'cli_cidade' => 'Belo Horizonte',
        'cli_estado' => 'MG',
        'cli_cep' => '30110-000',
        'cli_telefone' => '(31) 3000-0000',
        'cli_celular' => '(31) 99999-9999',
        'cli_email' => fake()->unique()->safeEmail(),
        'cli_ativo' => 1,
        'created_at' => now(),
        'updated_at' => now(),
    ]);
}

function criarProdutoOrcamento(): int
{
    return DB::table('cad_produtos')->insertGetId([
        'prod_codigo' => 'PRD'.fake()->unique()->numerify('###'),
        'prod_nome' => 'Produto Orcamento',
        'prod_tempo_estimado' => 3600,
        'prod_valor' => 150.90,
        'prod_ativo' => 1,
        'created_at' => now(),
        'updated_at' => now(),
    ]);
}

function payloadOrcamento(int $cliId, int $prodId, array $overrides = []): array
{
    return array_merge([
        'cli_id' => $cliId,
        'orc_data_emissao' => now()->format('Y-m-d'),
        'orc_data_validade' => now()->addDays(10)->format('Y-m-d'),
        'orc_desconto_percentual' => '5,00',
        'orc_observacoes' => 'Observacao teste',
        'itens' => [
            [
                'prod_id' => $prodId,
                'oci_quantidade' => '2',
                'oci_valor_unitario' => '150,90',
            ],
        ],
    ], $overrides);
}

beforeEach(function (): void {
    $_SERVER['REMOTE_ADDR'] = '127.0.0.1';
    $this->user = Usuarios::factory()->create();
    concederPermissoesOrcamentos($this->user);

    $this->cliId = criarClienteOrcamento();
    $this->prodId = criarProdutoOrcamento();
});

it('cria orcamento com itens e totais', function (): void {
    $response = $this->actingAs($this->user)
        ->post(route('orcamento::orcamentos.store'), payloadOrcamento($this->cliId, $this->prodId));

    $response->assertRedirect();
    $response->assertSessionHas('message.type', 'success');

    $orcamento = DB::table('orc_orcamentos')->first();
    expect($orcamento)->not->toBeNull();
    expect($orcamento->orc_status)->toBe('Rascunho');

    $itens = DB::table('orc_orcamento_itens')->where('orc_id', $orcamento->orc_id)->count();
    expect($itens)->toBe(1);
});

it('edita orcamento existente e atualiza status manualmente', function (): void {
    $this->actingAs($this->user)
        ->post(route('orcamento::orcamentos.store'), payloadOrcamento($this->cliId, $this->prodId));

    $orcamentoId = DB::table('orc_orcamentos')->value('orc_id');

    $payloadUpdate = payloadOrcamento($this->cliId, $this->prodId, [
        'orc_desconto_percentual' => '10,00',
        'orc_observacoes' => 'Atualizado',
        'itens' => [
            [
                'prod_id' => $this->prodId,
                'oci_quantidade' => '3',
                'oci_valor_unitario' => '180,00',
            ],
        ],
    ]);

    $updateResponse = $this->actingAs($this->user)
        ->put(route('orcamento::orcamentos.update', $orcamentoId), $payloadUpdate);

    $updateResponse->assertRedirect(route('orcamento::orcamentos.show', $orcamentoId));
    $updateResponse->assertSessionHas('message.type', 'success');

    $statusResponse = $this->actingAs($this->user)
        ->post(route('orcamento::orcamentos.update-status', $orcamentoId), [
            'orc_status' => 'Aprovado',
        ]);

    $statusResponse->assertRedirect();
    $statusResponse->assertSessionHas('message.type', 'success');

    $orcamento = DB::table('orc_orcamentos')->where('orc_id', $orcamentoId)->first();
    expect($orcamento->orc_status)->toBe('Aprovado');
    expect($orcamento->orc_observacoes)->toBe('Atualizado');
});

it('duplica orcamento criando um novo em rascunho', function (): void {
    $this->actingAs($this->user)
        ->post(route('orcamento::orcamentos.store'), payloadOrcamento($this->cliId, $this->prodId));

    $orcamentoOriginalId = DB::table('orc_orcamentos')->value('orc_id');

    $response = $this->actingAs($this->user)
        ->post(route('orcamento::orcamentos.duplicate', $orcamentoOriginalId));

    $response->assertRedirect();
    $response->assertSessionHas('message.type', 'success');

    $orcamentos = DB::table('orc_orcamentos')->orderBy('orc_id')->get();
    expect($orcamentos)->toHaveCount(2);
    expect($orcamentos->last()->orc_status)->toBe('Rascunho');

    $itensNovo = DB::table('orc_orcamento_itens')->where('orc_id', $orcamentos->last()->orc_id)->count();
    expect($itensNovo)->toBe(1);
});

it('bloqueia transicao invalida de status', function (): void {
    $this->actingAs($this->user)
        ->post(route('orcamento::orcamentos.store'), payloadOrcamento($this->cliId, $this->prodId));

    $orcamentoId = DB::table('orc_orcamentos')->value('orc_id');

    $this->actingAs($this->user)
        ->post(route('orcamento::orcamentos.update-status', $orcamentoId), [
            'orc_status' => 'Aprovado',
        ]);

    $response = $this->actingAs($this->user)
        ->from(route('orcamento::orcamentos.show', $orcamentoId))
        ->post(route('orcamento::orcamentos.update-status', $orcamentoId), [
            'orc_status' => 'Rascunho',
        ]);

    $response->assertRedirect(route('orcamento::orcamentos.show', $orcamentoId));
    $response->assertSessionHasErrors('orc_status');

    $orcamento = DB::table('orc_orcamentos')->where('orc_id', $orcamentoId)->first();
    expect($orcamento->orc_status)->toBe('Aprovado');
});

it('registra motivo no historico ao alterar status', function (): void {
    $this->actingAs($this->user)
        ->post(route('orcamento::orcamentos.store'), payloadOrcamento($this->cliId, $this->prodId));

    $orcamentoId = DB::table('orc_orcamentos')->value('orc_id');
    $motivo = 'Aprovado em reuniao comercial.';

    $response = $this->actingAs($this->user)
        ->post(route('orcamento::orcamentos.update-status', $orcamentoId), [
            'orc_status' => 'Aprovado',
            'motivo_status' => $motivo,
        ]);

    $response->assertRedirect();
    $response->assertSessionHas('message.type', 'success');

    $historico = DB::table('orc_status_historicos')
        ->where('orc_id', $orcamentoId)
        ->where('osh_status_novo', 'Aprovado')
        ->first();

    expect($historico)->not->toBeNull();
    expect($historico->osh_status_anterior)->toBe('Rascunho');
    expect($historico->osh_motivo)->toBe($motivo);
});

it('filtra listagem por status e periodo de criacao', function (): void {
    $this->actingAs($this->user)
        ->post(route('orcamento::orcamentos.store'), payloadOrcamento($this->cliId, $this->prodId, [
            'orc_data_emissao' => now()->subDays(20)->format('Y-m-d'),
            'orc_data_validade' => now()->subDays(10)->format('Y-m-d'),
        ]));

    $orcamentoAntigo = DB::table('orc_orcamentos')->orderBy('orc_id')->first();

    $this->actingAs($this->user)
        ->post(route('orcamento::orcamentos.store'), payloadOrcamento($this->cliId, $this->prodId));

    $orcamentoAtualId = (int) DB::table('orc_orcamentos')->max('orc_id');

    $this->actingAs($this->user)
        ->post(route('orcamento::orcamentos.update-status', $orcamentoAtualId), [
            'orc_status' => 'Aprovado',
        ]);

    $orcamentoAtual = DB::table('orc_orcamentos')->where('orc_id', $orcamentoAtualId)->first();

    $response = $this->actingAs($this->user)
        ->get(route('orcamento::orcamentos.index', [
            'status' => 'Aprovado',
            'data_inicio' => now()->subDay()->format('Y-m-d'),
            'data_fim' => now()->addDay()->format('Y-m-d'),
        ]));

    $response->assertOk();
    $response->assertSee((string) $orcamentoAtual->orc_numero);
    $response->assertDontSee((string) $orcamentoAntigo->orc_numero);
});

it('filtra listagem por cliente e periodo de validade', function (): void {
    $clienteSecundarioId = criarClienteOrcamento('Cliente Secundario');

    $this->actingAs($this->user)
        ->post(route('orcamento::orcamentos.store'), payloadOrcamento($this->cliId, $this->prodId, [
            'orc_data_validade' => now()->addDays(30)->format('Y-m-d'),
        ]));

    $orcamentoPrincipal = DB::table('orc_orcamentos')->orderBy('orc_id')->first();

    $this->actingAs($this->user)
        ->post(route('orcamento::orcamentos.store'), payloadOrcamento($clienteSecundarioId, $this->prodId, [
            'orc_data_validade' => now()->addDays(5)->format('Y-m-d'),
        ]));

    $orcamentoSecundario = DB::table('orc_orcamentos')->orderByDesc('orc_id')->first();

    $response = $this->actingAs($this->user)
        ->get(route('orcamento::orcamentos.index', [
            'cli_id' => $this->cliId,
            'data_validade_inicio' => now()->addDays(25)->format('Y-m-d'),
            'data_validade_fim' => now()->addDays(35)->format('Y-m-d'),
        ]));

    $response->assertOk();
    $response->assertSee((string) $orcamentoPrincipal->orc_numero);
    $response->assertDontSee((string) $orcamentoSecundario->orc_numero);
});
