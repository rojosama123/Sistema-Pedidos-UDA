<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class PedidoController extends Controller
{
    // === DASHBOARD PRINCIPAL ===
    public function index(Request $request)
    {
        $hoy = Carbon::now()->toDateString();

        if ($request->filled('casino')) {
            session(['casino_actual' => $request->casino]);
        }

        $casino = session('casino_actual', 'Casino Norte');

        $pedidos = Pedido::with('detalles') // relación en el modelo Pedido
            ->whereDate('fecha', $hoy)
            ->where('casino', $casino)
            ->orderBy('hora')
            ->paginate(10);

        return view('dashboard', compact('pedidos', 'casino'));
    }

    public function cambiarEstado(Request $request, Pedido $pedido)
    {
        $request->validate([
            'estado' => 'required|string|in:En Preparación,Listo para retirar,Entregado,Cancelado',
        ]);

        $pedido->estado = $request->estado;
        $pedido->save();

        return redirect()->back()->with('success', 'Estado del pedido actualizado correctamente.');
    }

    // === HISTORIAL DE PEDIDOS ===
    public function historial(Request $request)
    {
        if ($request->filled('casino')) {
            session(['casino_actual' => $request->casino]);
        }

        $casino = session('casino_actual', 'Casino Norte');

        $query = Pedido::with('detalles')->where('casino', $casino);

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
                // handled below
                break;
        }

        if ($request->fecha_inicio && $request->fecha_fin) {
            $fechaInicio = Carbon::parse($request->fecha_inicio)->startOfDay();
            $fechaFin = Carbon::parse($request->fecha_fin)->endOfDay();
            $query->whereBetween('fecha', [$fechaInicio, $fechaFin]);
        }

        if ($request->estado && $request->estado !== 'todos') {
            $query->where('estado', $request->estado);
        }

        $orden = $request->get('orden', 'asc'); // 'asc' por defecto

        $pedidos = $query->orderBy('id', $orden)->paginate(10);

        return view('pedidos.historial', compact('pedidos', 'casino', 'orden'));
    }

    
}
