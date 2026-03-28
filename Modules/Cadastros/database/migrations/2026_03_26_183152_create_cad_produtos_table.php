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
        Schema::create('cad_produtos', function (Blueprint $table) {
            $table->id('prod_id');
            $table->string('prod_codigo')->unique();
            $table->string('prod_nome');
            $table->integer('prod_tempo_estimado'); // segundos por peça
            $table->boolean('prod_ativo')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cad_produtos');
    }
};
