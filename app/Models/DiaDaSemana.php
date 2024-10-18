<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiaDaSemana extends Model
{
    use HasFactory;

    protected $table = 'dias_da_semana';
    protected $fillable = ['numero','nome','horario_inicio','horario_fim'];
    public function plantasPorDia()
    {
        return $this->hasMany(PlantaPorDiaDaSemana::class, 'dia_da_semana_id');
    }
}
