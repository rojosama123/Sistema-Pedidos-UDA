<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function index(Request $request)
    {
        if ($request->filled('casino')) {
            session(['casino_actual' => $request->casino]);
        }

        $casino = session('casino_actual', 'Casino Norte');

        // Consulta base
        $query = Review::with('user')
            ->where('casino', $casino) // 🔍 Filtrar por casino actual
            ->latest();

        // Filtro por calificación
        if ($request->filled('calificacion')) {
            $query->where('calificacion', $request->calificacion);
        }

        // Filtro por fecha
        if ($request->filled('desde')) {
            $query->whereDate('created_at', '>=', $request->desde);
        }

        if ($request->filled('hasta')) {
            $query->whereDate('created_at', '<=', $request->hasta);
        }

        $reseñas = $query->paginate(20);

        $promedio = Review::where('casino', $casino)->avg('calificacion');

        return view('reseñas.index', compact('reseñas', 'casino', 'promedio'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'casino' => 'required|string|max:255',
            'comentario' => 'required|string|max:1000',
            'calificacion' => 'required|integer|min:1|max:5',
        ]);

        $userId = Auth::id();
        $casino = $request->casino;
        $hoy = now()->toDateString();

        // Verifica si el usuario tiene un pedido hoy en ese casino
        $tienePedido = \App\Models\Pedido::where('user_id', $userId)
            ->where('casino', $casino)
            ->whereDate('fecha', $hoy)
            ->exists();

        if (!$tienePedido) {
            return response()->json([
                'success' => false,
                'message' => 'Solo puedes opinar si has realizado un pedido hoy en este casino.'
            ]);
        }

        Review::create([
            'user_id' => $userId,
            'comentario' => $request->comentario,
            'calificacion' => $request->calificacion,
            'casino' => $casino,
        ]);

        return response()->json(['success' => true]);
    }
}
