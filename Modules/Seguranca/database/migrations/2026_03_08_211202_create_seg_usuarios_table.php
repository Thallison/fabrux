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
        Schema::create('seg_usuarios', function (Blueprint $table) {
            $table->id('usr_id');
            $table->string('usr_login',50);
            $table->string('password');
            $table->string('usr_name',100);
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('remember_token', 100)->nullable();
            $table->boolean('usr_status')->default(false);
            $table->timestamp('usr_dt_criacao');
            $table->timestamp('usr_dt_alteracao')->nullable();
            $table->timestamp('usr_dt_ultimo_acesso')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seg_usuarios');
    }
};
