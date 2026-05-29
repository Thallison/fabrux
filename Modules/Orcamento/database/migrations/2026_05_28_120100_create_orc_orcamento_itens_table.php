<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orc_orcamento_itens', function (Blueprint $table) {
            $table->id('oci_id');
            $table->foreignId('orc_id')->constrained('orc_orcamentos', 'orc_id')->onDelete('cascade');
            $table->foreignId('prod_id')->constrained('cad_produtos', 'prod_id')->onDelete('restrict');
            $table->string('oci_produto_codigo');
            $table->string('oci_produto_nome');
            $table->decimal('oci_quantidade', 12, 3);
            $table->decimal('oci_valor_unitario', 12, 2);
            $table->decimal('oci_total', 12, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orc_orcamento_itens');
    }
};
