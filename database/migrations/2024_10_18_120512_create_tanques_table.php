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
        Schema::create('tanques', function (Blueprint $table) {
            $table->id();
            $table->foreignId('planta_id')->constrained('plantas');
            $table->double('maximo');
            $table->double('minimo');
            $table->double('estoque_atual');
            $table->double('consumo_medio');
            $table->double('ponto_de_pedido');
            $table->double('ponto_de_entrega')->nullable();
            $table->integer('lead_time');
            $table->double('qtd_entrega_padrao');
            $table->foreignId('unidade_de_medida_id')->constrained('unidades_de_medidas');
            $table->string('id_externo')->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tanques');
    }
};
