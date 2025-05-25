<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class PedidoController extends Controller
{
    public function index()
    {
        $hoy = Carbon::now()->toDateString();

        $pedidos = Pedido::whereDate('fecha', $hoy)->paginate(10); 

        return view('dashboard', compact('pedidos'));
    }

    public function mostrar($nombre)
    {
        // Cargar pedidos o simplemente pasar el nombre del casino
        return view('pedidos.index', ['casino' => ucfirst($nombre)]);
    }



    // Controlador para el historial de pedidos
    public function historial(Request $request)
    {
        $query = Pedido::query();

        // Filtro por fecha
        switch ($request->filtro_fecha) {
            case 'hoy':
                $query->whereDate('fecha', Carbon::today());
                break;
            case '7dias':
                $query->whereBetween('fecha', [Carbon::now()->subDays(6), Carbon::today()]);
                break;
            case 'mes':
                $query->whereMonth('fecha', Carbon::now()->month);
                break;
            case 'rango':
                break;
        }

        // Filtro por rango de fechas
        if ($request->fecha_inicio && $request->fecha_fin) {
            $fechaInicio = Carbon::parse($request->fecha_inicio)->startOfDay();
            $fechaFin = Carbon::parse($request->fecha_fin)->endOfDay();
            $query->whereBetween('fecha', [$fechaInicio, $fechaFin]);
        }

        // Filtro por estado
        if ($request->estado && $request->estado !== 'todos') {
            $query->where('estado', $request->estado);
        }

        $pedidos = $query->orderBy('fecha', 'desc')
                 ->orderBy('hora', 'desc') // <- Añadir esto si usas campo `hora`
                 ->orderBy('id', 'desc')   // <- Asegura orden aún si misma fecha/hora
                 ->paginate(10); // paginación
                                 

        return view('pedidos.historial', compact('pedidos'));
    }
}