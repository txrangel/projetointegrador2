<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tanque extends Model
{
    use HasFactory;

    protected $table = 'tanques';
    protected $fillable = [
        'planta_id',
        'maximo',
        'minimo',
        'unidade_de_medida_id',
        'id_externo',
        'estoque_atual',
        'consumo_medio',
        'ponto_de_pedido',
        'ponto_de_entrega',
        'qtd_entrega_padrao',
        'lead_time'
    ];
    
    public function planta()
    {
        return $this->belongsTo(Planta::class, 'planta_id');
    }

    public function unidadeDeMedida()
    {
        return $this->belongsTo(UnidadeDeMedida::class, 'unidade_de_medida_id');
    }

    public function dadosConsumo()
    {
        return $this->hasMany(DadoConsumo::class, 'tanque_id');
    }
}
