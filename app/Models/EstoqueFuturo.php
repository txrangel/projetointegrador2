<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EstoqueFuturo extends Model
{
    protected $table = 'estoque_futuro';
    protected $fillable = [
        'data',
        'nivel',
        'tanque_id',
        'ponto_pedido',
        'ponto_entrega'
    ];
    public function tanque()
    {
        return $this->belongsTo(Tanque::class, 'tanque_id');
    }
}
