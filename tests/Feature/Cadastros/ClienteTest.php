<?php

use Illuminate\Support\Facades\DB;
use Modules\Cadastros\Models\Clientes;
use Modules\Seguranca\Models\Usuarios;

function clientePayload(array $overrides = []): array
{
    return array_merge([
        'cli_codigo' => '',
        'cli_nome' => 'Cliente Teste',
        'cli_tipo' => 'F',
        'cli_cpf_cnpj' => fake()->unique()->numerify('###########'),
        'cli_ie' => '',
        'cli_im' => '',
        'cli_nao_contribuinte' => '0',
        'cli_substituto_tributario_iss' => '0',
        'cli_nao_calcula_diferimento_icms' => '0',
        'cli_apura_icms' => '0',
        'cli_aliquota_icms_diferenciada_contribuinte' => '0',
        'cli_logradouro' => 'Rua das Flores',
        'cli_numero' => '123',
        'cli_complemento' => '',
        'cli_bairro' => 'Centro',
        'cli_cidade' => 'Belo Horizonte',
        'cli_estado' => 'MG',
        'cli_cep' => '30150-000',
        'cli_telefone' => '(31) 3000-0000',
        'cli_celular' => '(31) 99999-9999',
        'cli_email' => fake()->unique()->safeEmail(),
        'cli_ativo' => '1',
    ], $overrides);
}

function concederPermissoesClientes(Usuarios $user, array $actions): void
{
    $agora = now();
    $sisId = DB::table('seg_sistemas')->insertGetId([
        'sis_nome' => 'Sistema Teste '.fake()->unique()->numerify('###'),
        'sis_icone' => 'bi bi-gear',
        'created_at' => $agora,
        'updated_at' => $agora,
    ]);

    $modId = DB::table('seg_modulos')->insertGetId([
        'sis_id' => $sisId,
        'mod_nome' => 'Modulo Cadastros '.fake()->unique()->numerify('###'),
        'mod_icone' => 'bi bi-pencil-square',
        'created_at' => $agora,
        'updated_at' => $agora,
    ]);

    $funcId = DB::table('seg_funcionalidades')->insertGetId([
        'mod_id' => $modId,
        'func_id_pai' => null,
        'func_controller' => 'Modules\\Cadastros\\Http\\Controllers\\ClientesController',
        'func_label' => 'Clientes',
        'func_tipo' => 'Controller',
        'func_acesso_menu' => 1,
        'func_icon' => 'bi bi-circle',
        'func_rota_padrao' => 'cadastros::clientes.index',
        'created_at' => $agora,
        'updated_at' => $agora,
    ]);

    $papelId = DB::table('seg_papeis')->insertGetId([
        'papel_nome' => 'Papel Clientes '.fake()->unique()->numerify('###'),
        'created_at' => $agora,
        'updated_at' => $agora,
    ]);

    foreach ($actions as $action) {
        $privId = DB::table('seg_privilegios')->insertGetId([
            'func_id' => $funcId,
            'priv_label' => 'Clientes '.strtoupper($action),
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

beforeEach(function (): void {
    $_SERVER['REMOTE_ADDR'] = '127.0.0.1';
    $this->user = Usuarios::factory()->create();
    concederPermissoesClientes($this->user, [
        'index',
        'create',
        'store',
        'show',
        'edit',
        'update',
        'destroy',
    ]);
});

it('cria cliente com sucesso', function (): void {
    $payload = clientePayload();

    $response = $this->actingAs($this->user)->post(route('cadastros::clientes.store'), $payload);

    $response->assertRedirect(route('cadastros::clientes.index'));
    $response->assertSessionHas('message.type', 'success');

    $this->assertDatabaseHas('cad_clientes', [
        'cli_nome' => $payload['cli_nome'],
        'cli_cpf_cnpj' => $payload['cli_cpf_cnpj'],
        'cli_email' => $payload['cli_email'],
    ]);

    $cliente = Clientes::query()->where('cli_email', $payload['cli_email'])->first();
    expect($cliente)->not->toBeNull();
    expect($cliente->cli_codigo)->toStartWith('CLI');
});

it('lista e visualiza cliente', function (): void {
    $cliente = Clientes::factory()->create();

    $indexResponse = $this->actingAs($this->user)->get(route('cadastros::clientes.index'));
    $indexResponse->assertOk();

    $showResponse = $this->actingAs($this->user)->get(route('cadastros::clientes.show', $cliente->cli_id));
    $showResponse->assertOk();
    $showResponse->assertSee($cliente->cli_nome);
});

it('atualiza cliente com sucesso e nao permite alterar codigo', function (): void {
    $cliente = Clientes::factory()->create();
    $codigoOriginal = $cliente->cli_codigo;

    $payload = clientePayload([
        'cli_codigo' => 'CLI999999',
        'cli_nome' => 'Cliente Atualizado',
        'cli_tipo' => $cliente->cli_tipo,
        'cli_cpf_cnpj' => $cliente->cli_cpf_cnpj,
        'cli_email' => fake()->unique()->safeEmail(),
    ]);

    $response = $this->actingAs($this->user)->put(route('cadastros::clientes.update', $cliente->cli_id), $payload);

    $response->assertRedirect(route('cadastros::clientes.index'));
    $response->assertSessionHas('message.type', 'success');

    $cliente->refresh();
    expect($cliente->cli_nome)->toBe('Cliente Atualizado');
    expect($cliente->cli_codigo)->toBe($codigoOriginal);
});

it('remove cliente com sucesso', function (): void {
    $cliente = Clientes::factory()->create();

    $response = $this->actingAs($this->user)->delete(route('cadastros::clientes.destroy', $cliente->cli_id));

    $response->assertOk();
    $response->assertJson([
        'type' => 'success',
    ]);

    $this->assertDatabaseMissing('cad_clientes', [
        'cli_id' => $cliente->cli_id,
    ]);
});

it('valida campos obrigatorios no cadastro', function (): void {
    $payload = clientePayload([
        'cli_nome' => '',
        'cli_logradouro' => '',
        'cli_email' => '',
    ]);

    $response = $this->actingAs($this->user)->post(route('cadastros::clientes.store'), $payload);

    $response->assertSessionHasErrors([
        'cli_nome',
        'cli_logradouro',
        'cli_email',
    ]);
});

it('exige autenticacao para acessar o cadastro de clientes', function (): void {
    $response = $this->get(route('cadastros::clientes.index'));

    $response->assertRedirectContains('/login');
});

it('permite acesso para usuario autenticado sem perfil de clientes', function (): void {
    $usuarioSemPermissao = Usuarios::factory()->create();

    $response = $this->actingAs($usuarioSemPermissao)->get(route('cadastros::clientes.index'));

    $response->assertOk();
});

it('permite acesso para usuario com perfil e privilegio de clientes', function (): void {
    $response = $this->actingAs($this->user)->get(route('cadastros::clientes.index'));

    $response->assertOk();
});

it('valida cpf cnpj unico no cadastro', function (): void {
    $clienteExistente = Clientes::factory()->create();

    $payload = clientePayload([
        'cli_cpf_cnpj' => $clienteExistente->cli_cpf_cnpj,
        'cli_email' => fake()->unique()->safeEmail(),
    ]);

    $response = $this->actingAs($this->user)->post(route('cadastros::clientes.store'), $payload);

    $response->assertSessionHasErrors(['cli_cpf_cnpj']);
});

it('valida email unico no cadastro', function (): void {
    $clienteExistente = Clientes::factory()->create();

    $payload = clientePayload([
        'cli_cpf_cnpj' => fake()->unique()->numerify('###########'),
        'cli_email' => $clienteExistente->cli_email,
    ]);

    $response = $this->actingAs($this->user)->post(route('cadastros::clientes.store'), $payload);

    $response->assertSessionHasErrors(['cli_email']);
});

it('retorna listagem em json no index ajax', function (): void {
    Clientes::factory()->count(3)->create();

    $response = $this->actingAs($this->user)
        ->withHeader('X-Requested-With', 'XMLHttpRequest')
        ->get(route('cadastros::clientes.index', ['search' => '', 'limit' => 10, 'offset' => 0]));

    $response->assertOk();
    $response->assertJsonStructure([
        'total',
        'rows',
    ]);
    $response->assertJsonPath('total', 3);
});
