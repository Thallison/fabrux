<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orc_cabecalhos', function (Blueprint $table) {
            $table->id('orc_cab_id');
            $table->string('orc_cab_nome')->nullable();
            $table->string('orc_cab_documento', 30)->nullable();
            $table->string('orc_cab_endereco')->nullable();
            $table->string('orc_cab_telefone', 30)->nullable();
            $table->string('orc_cab_email')->nullable();
            $table->string('orc_cab_site')->nullable();
            $table->text('orc_cab_rodape')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orc_cabecalhos');
    }
};
