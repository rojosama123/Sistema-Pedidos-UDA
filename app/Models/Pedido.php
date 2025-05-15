<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Pedido extends Model
{
    protected $table = 'pedidos';
    protected $fillable = [
        'nombre', 'menu', 'fecha', 'hora', 'nota_cliente', 'estado'
    ];

}
