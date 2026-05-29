<?php

namespace Modules\Orcamento\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CreateFuncionalidadeMenuSeeder extends Seeder
{
    public function run(): void
    {
        $agora = now();

        $modulo = DB::table('seg_modulos')->where('mod_nome', 'Orcamento')->first();

        if (! $modulo) {
            $modId = DB::table('seg_modulos')->insertGetId([
                'sis_id' => 1,
                'mod_nome' => 'Orcamento',
                'mod_icone' => 'bi bi-receipt-cutoff',
                'created_at' => $agora,
                'updated_at' => null,
            ]);
        } else {
            $modId = $modulo->mod_id;
        }

        $controller = 'Modules\\Orcamento\\Http\\Controllers\\OrcamentosController';

        $funcionalidade = DB::table('seg_funcionalidades')
            ->where('func_controller', $controller)
            ->where('func_label', 'Orcamentos')
            ->first();

        if (! $funcionalidade) {
            $funcId = DB::table('seg_funcionalidades')->insertGetId([
                'mod_id' => $modId,
                'func_id_pai' => null,
                'func_controller' => $controller,
                'func_label' => 'Orcamentos',
                'func_tipo' => 'Controller',
                'func_acesso_menu' => 1,
                'func_icon' => 'bi bi-circle',
                'func_rota_padrao' => 'orcamento::orcamentos.index',
                'created_at' => $agora,
                'updated_at' => null,
            ]);
        } else {
            $funcId = $funcionalidade->func_id;
        }

        $privilegios = [
            ['label' => 'Listar Orcamentos', 'action' => 'index'],
            ['label' => 'Cadastrar Orcamentos', 'action' => 'create'],
            ['label' => 'Visualizar Orcamentos', 'action' => 'show'],
            ['label' => 'Excluir Orcamentos', 'action' => 'destroy'],
            ['label' => 'Enviar Orcamentos', 'action' => 'sendEmail'],
            ['label' => 'Configurar Cabecalho Orcamentos', 'action' => 'headerConfig'],
        ];

        $mapaPrivilegios = [];

        foreach ($privilegios as $privilegio) {
            $registro = DB::table('seg_privilegios')
                ->where('func_id', $funcId)
                ->where('priv_action', $privilegio['action'])
                ->first();

            if (! $registro) {
                $privId = DB::table('seg_privilegios')->insertGetId([
                    'func_id' => $funcId,
                    'priv_label' => $privilegio['label'],
                    'priv_action' => $privilegio['action'],
                    'created_at' => $agora,
                    'updated_at' => null,
                ]);
            } else {
                $privId = $registro->priv_id;
            }

            $mapaPrivilegios[$privilegio['action']] = $privId;
        }

        $dependencias = [
            ['priv_action' => 'Cadastrar Orcamentos', 'action' => 'store'],
            ['priv_action' => 'Visualizar Orcamentos', 'action' => 'previewPdf'],
            ['priv_action' => 'Visualizar Orcamentos', 'action' => 'downloadPdf'],
            ['priv_action' => 'Visualizar Orcamentos', 'action' => 'redirectWhatsapp'],
            ['priv_action' => 'Configurar Cabecalho Orcamentos', 'action' => 'saveHeaderConfig'],
        ];

        foreach ($dependencias as $dependencia) {
            $privId = null;

            if ($dependencia['priv_action'] === 'Cadastrar Orcamentos') {
                $privId = $mapaPrivilegios['create'] ?? null;
            }

            if ($dependencia['priv_action'] === 'Visualizar Orcamentos') {
                $privId = $mapaPrivilegios['show'] ?? null;
            }

            if ($dependencia['priv_action'] === 'Configurar Cabecalho Orcamentos') {
                $privId = $mapaPrivilegios['headerConfig'] ?? null;
            }

            if (! $privId) {
                continue;
            }

            $existe = DB::table('seg_dependencias_privilegios')
                ->where('priv_id', $privId)
                ->where('dep_priv_controller', $controller)
                ->where('dep_priv_action', $dependencia['action'])
                ->first();

            if (! $existe) {
                DB::table('seg_dependencias_privilegios')->insert([
                    'priv_id' => $privId,
                    'dep_priv_controller' => $controller,
                    'dep_priv_action' => $dependencia['action'],
                    'created_at' => $agora,
                    'updated_at' => null,
                ]);
            }
        }
    }
}
