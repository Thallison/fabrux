<?php

namespace Modules\Producao\Database\Seeders;

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
                'mod_id' => 3,
                'sis_id' => 1,
                'mod_nome' => 'Produção',
                'mod_icone' => 'bi bi-clipboard-fill',
                'created_at' => now(),
                'updated_at' => null,
            ],
            /*[
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
                'func_id' => 10,
                'mod_id' => 3,
                'func_id_pai' => null,
                'func_controller' => 'Modules\\Producao\\Http\\Controllers\\ProducoesController',
                'func_label' => 'Produção',
                'func_tipo' => 'Controller',
                'func_acesso_menu' => 1,
                'func_icon' => 'bi bi-circle',
                'func_rota_padrao' => 'producao::producoes.index',
            ]
        ]);

        DB::table('seg_privilegios')->insert([

            // Produção
            [
                'priv_id' => 34,
                'func_id' => 10,
                'priv_label' => 'Listar Produção',
                'priv_action' => 'index',
                'created_at' => now(),
                'updated_at' => null,
            ],
            [
                'priv_id' => 35,
                'func_id' => 10,
                'priv_label' => 'Cadastrar Produção',
                'priv_action' => 'create',
                'created_at' => now(),
                'updated_at' => null,
            ],
            [
                'priv_id' => 36,
                'func_id' => 10,
                'priv_label' => 'Excluir Produção',
                'priv_action' => 'destroy',
                'created_at' => now(),
                'updated_at' => null,
            ],
            [
                'priv_id' => 37,
                'func_id' => 10,
                'priv_label' => 'Editar Produção',
                'priv_action' => 'show',
                'created_at' => now(),
                'updated_at' => null,
            ],
        ]);

        DB::table('seg_dependencias_privilegios')->insert([
            [
                'dep_priv_id' => 20,
                'priv_id' => 37, // Editar Produção
                'dep_priv_controller' => 'Modules\\Producao\\Http\\Controllers\\ProducoesController',
                'dep_priv_action' => 'update',
                'created_at' => now(),
                'updated_at' => null,
            ],
            [
                'dep_priv_id' => 21,
                'priv_id' => 35, // Cadastrar Produção
                'dep_priv_controller' => 'Modules\\Producao\\Http\\Controllers\\ProducoesController',
                'dep_priv_action' => 'store',
                'created_at' => now(),
                'updated_at' => null,
            ]
         ]);
    }
}
