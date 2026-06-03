<?php

namespace Modules\Cadastros\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CreateFuncionalidadeSetoresMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $agora = now();
        $controller = 'Modules\\Cadastros\\Http\\Controllers\\SetoresController';

        $funcionalidade = DB::table('seg_funcionalidades')
            ->where('func_controller', $controller)
            ->where('func_label', 'Setores')
            ->first();

        if (! $funcionalidade) {
            $funcId = DB::table('seg_funcionalidades')->insertGetId([
                'mod_id' => 2,
                'func_id_pai' => null,
                'func_controller' => $controller,
                'func_label' => 'Setores',
                'func_tipo' => 'Controller',
                'func_acesso_menu' => 1,
                'func_icon' => 'bi bi-circle',
                'func_rota_padrao' => 'cadastros::setores.index',
                'created_at' => $agora,
                'updated_at' => null,
            ]);
        } else {
            $funcId = $funcionalidade->func_id;
        }

        $privilegios = [
            ['label' => 'Listar Setores', 'action' => 'index'],
            ['label' => 'Cadastrar Setores', 'action' => 'create'],
            ['label' => 'Excluir Setores', 'action' => 'destroy'],
            ['label' => 'Editar Setores', 'action' => 'show'],
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
            ['priv_action' => 'show', 'action' => 'update'],
            ['priv_action' => 'create', 'action' => 'store'],
            ['priv_action' => 'index', 'action' => 'show'],
        ];

        foreach ($dependencias as $dependencia) {
            $privId = $mapaPrivilegios[$dependencia['priv_action']] ?? null;

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
