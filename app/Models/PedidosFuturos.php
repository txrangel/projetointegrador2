<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PedidosFuturos extends Model
{
    protected $table = 'pedidos_futuros';
    protected $fillable = [
        'tanque_id',
        'nivel_atual',
        'quantidade',
        'data',
    ];
    public function tanque()
    {
        return $this->belongsTo(Tanque::class, 'tanque_id');
    }
}
