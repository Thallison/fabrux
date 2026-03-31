<?php

namespace Modules\Relatorios\Database\Seeders;

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
                'mod_id' => 4,
                'sis_id' => 1,
                'mod_nome' => 'Relatórios',
                'mod_icone' => 'bi bi-table',
                'created_at' => now(),
                'updated_at' => null,
            ]
        );

        DB::table('seg_funcionalidades')->insert([
            [
                'func_id' => 11,
                'mod_id' => 4,
                'func_id_pai' => null,
                'func_controller' => 'Modules\\Relatorios\\Http\\Controllers\\RelatóriosController',
                'func_label' => 'Relatórios',
                'func_tipo' => 'Controller',
                'func_acesso_menu' => 1,
                'func_icon' => 'bi bi-circle',
                'func_rota_padrao' => 'relatorios::relatorios.index',
            ],
            [
                'func_id' => 12,
                'mod_id' => 4,
                'func_id_pai' => 11,
                'func_controller' => 'Modules\\Relatorios\\Http\\Controllers\\RelatóriosController',
                'func_label' => 'Produção diária',
                'func_tipo' => 'Controller',
                'func_acesso_menu' => 1,
                'func_icon' => 'bi bi-circle',
                'func_rota_padrao' => 'relatorios::producao.diaria',
            ],
            [
                'func_id' => 13,
                'mod_id' => 4,
                'func_id_pai' => 11,
                'func_controller' => 'Modules\\Relatorios\\Http\\Controllers\\RelatóriosController',
                'func_label' => 'Produtividade funcionário',
                'func_tipo' => 'Controller',
                'func_acesso_menu' => 1,
                'func_icon' => 'bi bi-circle',
                'func_rota_padrao' => 'relatorios::produtividade.funcionario',
            ],
            [
                'func_id' => 14,
                'mod_id' => 4,
                'func_id_pai' => 11,
                'func_controller' => 'Modules\\Relatorios\\Http\\Controllers\\RelatóriosController',
                'func_label' => 'Produção produto',
                'func_tipo' => 'Controller',
                'func_acesso_menu' => 1,
                'func_icon' => 'bi bi-circle',
                'func_rota_padrao' => 'relatorios::producao.produto',
            ],
            [
                'func_id' => 15,
                'mod_id' => 4,
                'func_id_pai' => 11,
                'func_controller' => 'Modules\\Relatorios\\Http\\Controllers\\RelatóriosController',
                'func_label' => 'Comparativo',
                'func_tipo' => 'Controller',
                'func_acesso_menu' => 1,
                'func_icon' => 'bi bi-circle',
                'func_rota_padrao' => 'relatorios::comparativo',
            ],
            [
                'func_id' => 16,
                'mod_id' => 4,
                'func_id_pai' => 11,
                'func_controller' => 'Modules\\Relatorios\\Http\\Controllers\\RelatóriosController',
                'func_label' => 'Projeção',
                'func_tipo' => 'Controller',
                'func_acesso_menu' => 1,
                'func_icon' => 'bi bi-circle',
                'func_rota_padrao' => 'relatorios::projecao',
            ],

        ]);

        DB::table('seg_privilegios')->insert([

            // Produção
            [
                'priv_id' => 38,
                'func_id' => 12,
                'priv_label' => 'Produção diária',
                'priv_action' => 'productionDaily',
                'created_at' => now(),
                'updated_at' => null,
            ],
            [
                'priv_id' => 39,
                'func_id' => 13,
                'priv_label' => 'Produtividade funcionário',
                'priv_action' => 'productivityEmployee',
                'created_at' => now(),
                'updated_at' => null,
            ],
            [
                'priv_id' => 40,
                'func_id' => 14,
                'priv_label' => 'Produção produto',
                'priv_action' => 'productionProduct',
                'created_at' => now(),
                'updated_at' => null,
            ],
            [
                'priv_id' => 41,
                'func_id' => 15,
                'priv_label' => 'Comparativo',
                'priv_action' => 'comparison',
                'created_at' => now(),
                'updated_at' => null,
            ],
            [
                'priv_id' => 42,
                'func_id' => 16,
                'priv_label' => 'Projeção',
                'priv_action' => 'projection',
                'created_at' => now(),
                'updated_at' => null,
            ],
        ]);
    }
}
