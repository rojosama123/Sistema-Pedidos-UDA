<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class PedidoController extends Controller
{
    public function index()
    {
     $hoy = Carbon::now()->toDateString(); // '2025-05-14'

    $pedidos = Pedido::whereDate('fecha', $hoy)->get();

    return view('dashboard', compact('pedidos'));
    }
    public function mostrar($nombre)
    {
        // Puedes cargar pedidos o simplemente pasar el nombre del casino
        return view('pedidos.index', ['casino' => ucfirst($nombre)]);
    }
}