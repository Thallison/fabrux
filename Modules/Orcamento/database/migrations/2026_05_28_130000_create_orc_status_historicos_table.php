<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orc_status_historicos', function (Blueprint $table) {
            $table->id('osh_id');
            $table->foreignId('orc_id')->constrained('orc_orcamentos', 'orc_id')->onDelete('cascade');
            $table->unsignedBigInteger('usr_id')->nullable();
            $table->string('osh_status_anterior', 20)->nullable();
            $table->string('osh_status_novo', 20);
            $table->string('osh_motivo', 500)->nullable();
            $table->timestamps();

            $table->foreign('usr_id')
                ->references('usr_id')
                ->on('seg_usuarios')
                ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orc_status_historicos');
    }
};
