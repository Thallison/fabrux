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
        Schema::create('seg_Logs', function (Blueprint $table) {
            $table->id('log_id');
            $table->foreignId('usr_id')->constrained('seg_usuarios','usr_id');
            $table->string('log_controller', 100);
            $table->string('log_action', 45);
            $table->string('log_nome_rota', 100)->nullable(true);
            $table->text('log_msg');
            $table->enum('log_tipo',['emergency', 'alert', 'critical', 'error', 'warning', 'notice', 'info', 'debug']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seg_Logs');
    }
};
