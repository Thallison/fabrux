<?php

namespace Modules\Cadastros\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CreateFuncionalidadeClientesMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('seg_funcionalidades')->insert([
            [
                'func_id' => 17,
                'mod_id' => 2,
                'func_id_pai' => null,
                'func_controller' => 'Modules\\Cadastros\\Http\\Controllers\\ClientesController',
                'func_label' => 'Clientes',
                'func_tipo' => 'Controller',
                'func_acesso_menu' => 1,
                'func_icon' => 'bi bi-circle',
                'func_rota_padrao' => 'cadastros::clientes.index',
            ],
        ]);

        DB::table('seg_privilegios')->insert([

            // clientes
            [
                'priv_id' => 43,
                'func_id' => 17,
                'priv_label' => 'Listar Clientes',
                'priv_action' => 'index',
                'created_at' => now(),
                'updated_at' => null,
            ],
            [
                'priv_id' => 44,
                'func_id' => 17,
                'priv_label' => 'Cadastrar Clientes',
                'priv_action' => 'create',
                'created_at' => now(),
                'updated_at' => null,
            ],
            [
                'priv_id' => 45,
                'func_id' => 17,
                'priv_label' => 'Excluir Clientes',
                'priv_action' => 'destroy',
                'created_at' => now(),
                'updated_at' => null,
            ],
            [
                'priv_id' => 46,
                'func_id' => 17,
                'priv_label' => 'Editar Clientes',
                'priv_action' => 'edit',
                'created_at' => now(),
                'updated_at' => null,
            ],
        ]);

        DB::table('seg_dependencias_privilegios')->insert([
            [
                'dep_priv_id' => 22,
                'priv_id' => 46, // Editar Clientes
                'dep_priv_controller' => 'Modules\\Cadastros\\Http\\Controllers\\ClientesController',
                'dep_priv_action' => 'update',
                'created_at' => now(),
                'updated_at' => null,
            ],
            [
                'dep_priv_id' => 23,
                'priv_id' => 44, // Cadastrar Clientes
                'dep_priv_controller' => 'Modules\\Cadastros\\Http\\Controllers\\ClientesController',
                'dep_priv_action' => 'store',
                'created_at' => now(),
                'updated_at' => null,
            ],
            [
                'dep_priv_id' => 24,
                'priv_id' => 43, // Listar Clientes
                'dep_priv_controller' => 'Modules\\Cadastros\\Http\\Controllers\\ClientesController',
                'dep_priv_action' => 'show',
                'created_at' => now(),
                'updated_at' => null,
            ],
        ]);
    }
}
