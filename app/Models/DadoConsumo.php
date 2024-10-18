<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DadoConsumo extends Model
{
    use HasFactory;

    protected $table = 'dados_consumo';
    protected $fillable = ['data_hora','nivel','tanque_id'];
    public function tanque()
    {
        return $this->belongsTo(Tanque::class, 'tanque_id');
    }
}
