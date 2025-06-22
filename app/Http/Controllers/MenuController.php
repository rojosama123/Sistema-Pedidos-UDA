<?php

namespace App\Http\Controllers;

use App\Models\MenuItem;
use Illuminate\Support\Carbon;
use App\Models\Review;

class MenuController extends Controller
{
    public function mostrarMenu($casino)
    {
        //dd($casino);
        $hoy = Carbon::now()->toDateString();

        $platos = MenuItem::where('fecha', $hoy)
                    ->where('casino', $casino)
                    ->get();

        $promedio = Review::where('casino', $casino)->avg('calificacion');
        return view('pedidos.index', compact('platos', 'casino', 'promedio'));
    }
}
