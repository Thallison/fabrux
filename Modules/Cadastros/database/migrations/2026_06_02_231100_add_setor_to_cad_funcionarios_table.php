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
        Schema::table('cad_funcionarios', function (Blueprint $table) {
            if (!Schema::hasColumn('cad_funcionarios', 'fun_set_id')) {
                $table->unsignedBigInteger('fun_set_id')->nullable()->after('fun_carga_horaria');
                $table->foreign('fun_set_id')->references('set_id')->on('cad_setores')->nullOnDelete();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cad_funcionarios', function (Blueprint $table) {
            if (Schema::hasColumn('cad_funcionarios', 'fun_set_id')) {
                $table->dropForeign(['fun_set_id']);
                $table->dropColumn('fun_set_id');
            }
        });
    }
};
