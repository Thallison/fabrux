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
        Schema::table('cad_produtos', function (Blueprint $table) {
            $table->decimal('prod_valor', 12, 2)->default(0)->after('prod_tempo_estimado');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cad_produtos', function (Blueprint $table) {
            $table->dropColumn('prod_valor');
        });
    }
};
