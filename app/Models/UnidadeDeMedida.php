<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnidadeDeMedida extends Model
{
    use HasFactory;

    protected $table = 'unidades_de_medidas';
    protected $fillable = ['nome','sigla'];
    public function tanques()
    {
        return $this->hasMany(Tanque::class, 'unidade_de_medida_id');
    }
}
