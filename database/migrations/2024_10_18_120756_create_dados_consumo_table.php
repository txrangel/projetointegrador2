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
        Schema::create('dados_consumo', function (Blueprint $table) {
            $table->id();
            $table->dateTime('data_hora');
            $table->double('nivel');
            $table->foreignId('tanque_id')->constrained('tanques');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dados_consumo');
    }
};
