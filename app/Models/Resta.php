<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resta extends Model
{
    use HasFactory;
    protected $fillable = [
        'enunciado', 'respuesta', 'grado', 'practico_id'
    ];
}
