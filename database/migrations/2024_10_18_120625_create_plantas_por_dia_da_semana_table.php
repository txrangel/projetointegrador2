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
        Schema::create('plantas_por_dia_da_semana', function (Blueprint $table) {
            $table->id();
            $table->foreignId('planta_id')->constrained('plantas');
            $table->foreignId('dia_da_semana_id')->constrained('dias_da_semana');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plantas_por_dia_da_semana');
    }
};
