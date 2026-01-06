<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ejercicio extends Model
{
    use HasFactory;

    protected $fillable = [
        'tipo',
        'enunciado',
        'respuesta',
        'grado',
        'practico_id',
    ];

    public function operandos()
    {
        return $this->hasMany(\App\Models\Operando::class);
    }

    public function practico()
    {
        return $this->belongsTo(\App\Models\Practico::class);
    }
}
