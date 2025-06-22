<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'user_id',
        'comentario',
        'calificacion',
        'casino',
    ];

    // Relación con el modelo User
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}