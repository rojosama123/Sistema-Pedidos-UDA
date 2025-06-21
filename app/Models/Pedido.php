<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pedido extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'fecha',
        'hora',
        'estado',
        'casino',
    ];

    // Relación: un pedido tiene muchos detalles
    public function detalles()
    {
        return $this->hasMany(PedidoDetalle::class);
    }
    public function usuario()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }

}