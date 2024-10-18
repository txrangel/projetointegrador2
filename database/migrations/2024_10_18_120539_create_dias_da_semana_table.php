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
        Schema::create('dias_da_semana', function (Blueprint $table) {
            $table->id();
            $table->integer('numero')->unique();
            $table->string('nome');
            $table->time('horario_inicio');
            $table->time('horario_fim');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dias_da_semana');
    }
};
