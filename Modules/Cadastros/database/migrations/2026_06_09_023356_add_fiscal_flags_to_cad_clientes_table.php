<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('cad_clientes', function (Blueprint $table) {
            $table->boolean('cli_nao_contribuinte')->default(false)->after('cli_im');
            $table->boolean('cli_substituto_tributario_iss')->default(false)->after('cli_nao_contribuinte');
            $table->boolean('cli_nao_calcula_diferimento_icms')->default(false)->after('cli_substituto_tributario_iss');
            $table->boolean('cli_apura_icms')->default(false)->after('cli_nao_calcula_diferimento_icms');
            $table->boolean('cli_aliquota_icms_diferenciada_contribuinte')->default(false)->after('cli_apura_icms');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cad_clientes', function (Blueprint $table) {
            $table->dropColumn([
                'cli_nao_contribuinte',
                'cli_substituto_tributario_iss',
                'cli_nao_calcula_diferimento_icms',
                'cli_apura_icms',
                'cli_aliquota_icms_diferenciada_contribuinte',
            ]);
        });
    }
};
