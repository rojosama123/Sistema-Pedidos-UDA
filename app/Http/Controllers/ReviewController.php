<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;

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
}
