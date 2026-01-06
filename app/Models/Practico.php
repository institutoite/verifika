<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Practico extends Model
{
    use HasFactory, \Illuminate\Database\Eloquent\SoftDeletes;

    protected $fillable = [
        'nombre',
        'fecha',
        'user_id',
    ];

    public function ejercicios()
    {
        return $this->hasMany(Ejercicio::class);
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function getFechaAttribute()
    {
        return $this->created_at ? $this->created_at->format('Y-m-d H:i') : '';
    }
}
