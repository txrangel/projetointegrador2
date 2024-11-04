<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EntregasFuturas extends Model
{
    protected $table = 'entregas_futuras';
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
