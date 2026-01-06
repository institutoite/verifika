<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Operando extends Model
{
    use HasFactory;

    protected $fillable = [
        'ejercicio_id',
        'valor',
    ];

    public function ejercicio()
    {
        return $this->belongsTo(Ejercicio::class);
    }
}
