<?php

namespace App\Http\Controllers;

use App\Models\MenuItem;
use Illuminate\Support\Carbon;

class MenuController extends Controller
{
    public function mostrarMenu($casino)
    {
        //dd($casino);
        $hoy = Carbon::now()->toDateString();

        $platos = MenuItem::where('fecha', $hoy)
                    ->where('casino', $casino)
                    ->get();

        return view('pedidos.index', compact('platos', 'casino', 'promedio'));
    }
}
