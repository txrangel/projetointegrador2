<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Planta extends Model
{
    use HasFactory;

    protected $table = 'plantas';
    protected $fillable = ['nome','endereco','cep'];

    public function tanques()
    {
        return $this->hasMany(Tanque::class, 'planta_id');
    }

    public function diasDaSemana()
    {
        return $this->belongsToMany(DiaDaSemana::class, 'plantas_por_dia_da_semana', 'planta_id', 'dia_da_semana_id');
    }
}
