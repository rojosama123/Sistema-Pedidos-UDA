<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\PedidoDetalle;
use Illuminate\Support\Facades\Auth;
use App\Models\Review;

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

        $pedidos = Pedido::with('detalles', 'usuario') // relación en el modelo Pedido
            ->whereDate('fecha', $hoy)
            ->where('casino', $casino)
            ->orderBy('hora')
            ->paginate(10);

        $promedio = Review::where('casino', $casino)->avg('calificacion');


        return view('dashboard', compact('pedidos', 'casino', 'promedio'));
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

        $query = Pedido::with('detalles', 'usuario')->where('casino', $casino);
        $promedio = Review::where('casino', $casino)->avg('calificacion');

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

        return view('pedidos.historial', compact('pedidos', 'casino', 'orden', 'promedio'));
    }
    
     public function guardar(Request $request)
    {
        $request->validate([
            'casino' => 'required|string',
            'platos' => 'required|array',
            'platos.*.nombre' => 'required|string',
            'platos.*.precio' => 'required|numeric',
            'platos.*.nota' => 'nullable|string'
        ]);

        $pedido = Pedido::create([
            'user_id' => Auth::id(),
            'fecha' => Carbon::now()->toDateString(),
            'hora' => Carbon::now()->toTimeString(),
            'estado' => 'pendiente',
            'casino' => $request->casino,
        ]);

        foreach ($request->platos as $plato) {
            PedidoDetalle::create([
                'pedido_id' => $pedido->id,
                'plato' => $plato['nombre'],
                'precio' => $plato['precio'],
                'nota_cliente' => $plato['nota'] ?? null,
            ]);
        }

        return response()->json(['success' => true, 'mensaje' => 'Pedido registrado correctamente.']);
    }
}