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
        Schema::create('seg_funcionalidades', function (Blueprint $table) {
            $table->id('func_id');
            $table->foreignId('mod_id')->constrained('seg_modulos','mod_id');
            $table->foreignId('func_id_pai')->nullable()->constrained('seg_funcionalidades','func_id');
            $table->string('func_controller', 100);
            $table->string('func_label', 45);
            $table->string('func_tipo', 45);
            $table->boolean('func_acesso_menu')->default(false);
            $table->string('func_icon', 45)->nullable();
            $table->string('func_rota_padrao', 100)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seg_funcionalidades');
    }
};
