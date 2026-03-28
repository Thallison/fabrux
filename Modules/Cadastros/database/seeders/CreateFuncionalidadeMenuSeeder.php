<?php

namespace Modules\Cadastros\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CreateFuncionalidadeMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('seg_modulos')->insert(
            [
                'mod_id' => 2,
                'sis_id' => 1,
                'mod_nome' => 'Cadastro',
                'mod_icone' => 'bi bi-pencil-square',
                'created_at' => now(),
                'updated_at' => null,
            ]
            /*[
                'mod_id' => 3,
                'sis_id' => 1,
                'mod_nome' => 'Produção',
                'mod_icone' => 'bi bi-clipboard-fill',
                'created_at' => now(),
                'updated_at' => null,
            ],
            [
                'mod_id' => 4,
                'sis_id' => 1,
                'mod_nome' => 'Relatórios',
                'mod_icone' => 'bi bi-table',
                'created_at' => now(),
                'updated_at' => null,
            ]*/
        );

        DB::table('seg_funcionalidades')->insert([
            [
                'func_id' => 8,
                'mod_id' => 2,
                'func_id_pai' => null,
                'func_controller' => 'Modules\\Cadastros\\Http\\Controllers\\FuncionariosController',
                'func_label' => 'Funcionarios',
                'func_tipo' => 'Controller',
                'func_acesso_menu' => 1,
                'func_icon' => 'bi bi-circle',
                'func_rota_padrao' => 'cadastros::funcionarios.index',
            ],
            [
                'func_id' => 9,
                'mod_id' => 2,
                'func_id_pai' => null,
                'func_controller' => 'Modules\\Cadastros\\Http\\Controllers\\ProdutosController',
                'func_label' => 'Produtos',
                'func_tipo' => 'Controller',
                'func_acesso_menu' => 1,
                'func_icon' => 'bi bi-circle',
                'func_rota_padrao' => 'cadastros::produtos.index',
            ]
        ]);

        DB::table('seg_privilegios')->insert([

            // Funcionarios
            [
                'priv_id' => 26,
                'func_id' => 8,
                'priv_label' => 'Listar Funcionarios',
                'priv_action' => 'index',
                'created_at' => now(),
                'updated_at' => null,
            ],
            [
                'priv_id' => 27,
                'func_id' => 8,
                'priv_label' => 'Cadastrar Funcionarios',
                'priv_action' => 'create',
                'created_at' => now(),
                'updated_at' => null,
            ],
            [
                'priv_id' => 28,
                'func_id' => 8,
                'priv_label' => 'Excluir Funcionarios',
                'priv_action' => 'destroy',
                'created_at' => now(),
                'updated_at' => null,
            ],
            [
                'priv_id' => 29,
                'func_id' => 8,
                'priv_label' => 'Editar Funcionarios',
                'priv_action' => 'show',
                'created_at' => now(),
                'updated_at' => null,
            ],

            // produtos
            [
                'priv_id' => 30,
                'func_id' => 9,
                'priv_label' => 'Listar Produtos',
                'priv_action' => 'index',
                'created_at' => now(),
                'updated_at' => null,
            ],
            [
                'priv_id' => 31,
                'func_id' => 9,
                'priv_label' => 'Cadastrar Produtos',
                'priv_action' => 'create',
                'created_at' => now(),
                'updated_at' => null,
            ],
            [
                'priv_id' => 32,
                'func_id' => 9,
                'priv_label' => 'Excluir Produtos',
                'priv_action' => 'destroy',
                'created_at' => now(),
                'updated_at' => null,
            ],
            [
                'priv_id' => 33,
                'func_id' => 9,
                'priv_label' => 'Editar Produtos',
                'priv_action' => 'show',
                'created_at' => now(),
                'updated_at' => null,
            ],
        ]);

        DB::table('seg_dependencias_privilegios')->insert([
            [
                'dep_priv_id' => 15,
                'priv_id' => 29, // Editar Funcionarios
                'dep_priv_controller' => 'Modules\\Cadastros\\Http\\Controllers\\FuncionariosController',
                'dep_priv_action' => 'update',
                'created_at' => now(),
                'updated_at' => null,
            ],
            [
                'dep_priv_id' => 16,
                'priv_id' => 27, // Cadastrar Funcionarios
                'dep_priv_controller' => 'Modules\\Seguranca\\Http\\Controllers\\FuncionariosController',
                'dep_priv_action' => 'store',
                'created_at' => now(),
                'updated_at' => null,
            ],
            [
                'dep_priv_id' => 17,
                'priv_id' => 33, // Editar Produtos
                'dep_priv_controller' => 'Modules\\Cadastros\\Http\\Controllers\\ProdutosController',
                'dep_priv_action' => 'update',
                'created_at' => now(),
                'updated_at' => null,
            ],
            [
                'dep_priv_id' => 18,
                'priv_id' => 31, // Cadastrar Produtos
                'dep_priv_controller' => 'Modules\\Seguranca\\Http\\Controllers\\ProdutosController',
                'dep_priv_action' => 'store',
                'created_at' => now(),
                'updated_at' => null,
            ],
         ]);
    }
}
