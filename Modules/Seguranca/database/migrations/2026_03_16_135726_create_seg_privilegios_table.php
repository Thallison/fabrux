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
        Schema::create('seg_privilegios', function (Blueprint $table) {
            $table->id('priv_id');
            $table->foreignId('func_id')->constrained('seg_funcionalidades','func_id');
            $table->string('priv_label', 45);
            $table->string('priv_action', 45);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seg_privilegios');
    }
};
