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
        Schema::create('pro_producoes', function (Blueprint $table) {
            $table->id('produ_id');

            $table->foreignId('fun_id')
                ->constrained('cad_funcionarios','fun_id')
                ->cascadeOnDelete();

            $table->foreignId('prod_id')
                ->constrained('cad_produtos', 'prod_id')
                ->cascadeOnDelete();

            $table->integer('produ_quantidade');

            $table->date('produ_data'); // dia da produção

            $table->time('produ_hora')->nullable(); // opcional (anti-fraude)

            $table->integer('produ_tempo_gasto')->nullable(); // segundos

            $table->timestamps();

            // performance futura
            $table->index(['produ_data', 'fun_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pro_producoes');
    }
};
