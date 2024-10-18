<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlantaPorDiaDaSemana extends Model
{
    use HasFactory;

    protected $table = 'plantas_por_dia_da_semana';
    protected $fillable = ['planta_id','dia_da_semana_id'];

    public function planta()
    {
        return $this->belongsTo(Planta::class, 'planta_id');
    }

    public function diaDaSemana()
    {
        return $this->belongsTo(DiaDaSemana::class, 'dia_da_semana_id');
    }
}
