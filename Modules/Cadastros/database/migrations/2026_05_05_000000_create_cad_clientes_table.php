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
        Schema::create('cad_clientes', function (Blueprint $table) {
            $table->id('cli_id');
            $table->string('cli_codigo', 200)->unique();

            // Dados básicos
            $table->string('cli_nome'); // Nome ou Razão Social
            $table->enum('cli_tipo', ['F', 'J']); // F = Pessoa Física, J = Pessoa Jurídica
            $table->string('cli_cpf_cnpj', 20)->unique();
            $table->string('cli_ie')->nullable(); // Inscrição Estadual
            $table->string('cli_im')->nullable(); // Inscrição Municipal

            // Endereço
            $table->string('cli_logradouro');
            $table->string('cli_numero');
            $table->string('cli_complemento')->nullable();
            $table->string('cli_bairro');
            $table->string('cli_cidade');
            $table->char('cli_estado', 2); // UF
            $table->string('cli_cep');

            // Contatos
            $table->string('cli_telefone')->nullable();
            $table->string('cli_celular')->nullable();
            $table->string('cli_email')->unique();

            // Status
            $table->boolean('cli_ativo')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cad_clientes');
    }
};
