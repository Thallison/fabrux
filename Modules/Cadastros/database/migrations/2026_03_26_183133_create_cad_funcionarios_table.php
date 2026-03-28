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
        Schema::create('cad_funcionarios', function (Blueprint $table) {
            $table->id('fun_id');
            $table->string('fun_codigo')->unique();
            $table->string('fun_nome');
            $table->integer('fun_carga_horaria'); // segundos
            $table->boolean('fun_ativo')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cad_funcionarios');
    }
};
