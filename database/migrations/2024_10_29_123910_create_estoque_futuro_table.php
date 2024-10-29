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
        Schema::create('estoque_futuro', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tanque_id')->constrained('tanques');
            $table->double('nivel');
            $table->date('data');
            $table->boolean('ponto_pedido');
            $table->boolean('ponto_entrega');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estoque_futuro');
    }
};
