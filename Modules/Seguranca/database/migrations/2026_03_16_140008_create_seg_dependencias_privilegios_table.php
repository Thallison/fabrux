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
        Schema::create('seg_dependencias_privilegios', function (Blueprint $table) {
            $table->id('dep_priv_id');
            $table->foreignId('priv_id')->constrained('seg_privilegios','priv_id');
            $table->string('dep_priv_controller', 100);
            $table->string('dep_priv_action', 45);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seg_dependencias_privilegios');
    }
};
