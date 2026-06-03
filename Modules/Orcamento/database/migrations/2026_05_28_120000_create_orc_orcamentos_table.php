<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orc_orcamentos', function (Blueprint $table) {
            $table->id('orc_id');
            $table->string('orc_numero', 200)->unique();
            $table->foreignId('cli_id')->constrained('cad_clientes', 'cli_id')->onDelete('restrict');
            $table->date('orc_data_emissao');
            $table->date('orc_data_validade');
            $table->decimal('orc_desconto_percentual', 5, 2)->default(0);
            $table->decimal('orc_subtotal', 12, 2);
            $table->decimal('orc_valor_desconto', 12, 2)->default(0);
            $table->decimal('orc_total', 12, 2);
            $table->string('orc_status', 20)->default('Rascunho');
            $table->text('orc_observacoes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orc_orcamentos');
    }
};
