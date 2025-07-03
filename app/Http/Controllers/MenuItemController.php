<?php

namespace App\Http\Controllers;

use App\Models\MenuItem;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Review; 

class MenuItemController extends Controller
{
    public function index(Request $request)
    {   
        if ($request->filled('casino')) {
            session(['casino_actual' => $request->casino]);
        }
        // Si no hay casino en la sesión, usar 'Casino Norte' por defecto
        $casino = session('casino_actual', 'Casino Norte');
        $menusAgrupados = MenuItem::where('casino', $casino)
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy('fecha');
        $promedio = Review::where('casino', $casino)->avg('calificacion');

        return view('menu.index', compact('menusAgrupados', 'casino', 'promedio'));
    }

    public function create(Request $request)
    {
        $casino = session('casino_actual', 'Casino Norte');
        $hoy = Carbon::today()->toDateString();

        // Asumiendo tienes un modelo Menu con 'fecha' y 'casino'
        $menuExistente = \App\Models\MenuItem::where('casino', $casino)
                        ->whereDate('fecha', $hoy)
                        ->exists();

        return view('menu.create_menu', compact('casino', 'menuExistente'));
    }

    public function store(Request $request)
    {
        $casino = session('casino_actual', 'Casino Norte');

        $request->validate([
            'items.*.nombre' => 'required|string',
            'items.*.precio' => 'required|numeric',
        ]);

        foreach ($request->items as $item) {
            MenuItem::create([
                'nombre' => $item['nombre'],
                'descripcion' => $item['descripcion'] ?? '', // Descripción opcional    
                'precio' => $item['precio'],
                'fecha' => Carbon::today()->toDateString(),
                'casino' => $casino
            ]);
        }

        return redirect()->route('menu.index')->with('success', 'Menú guardado correctamente.');
    }

    public function destroy($fecha)
    {
        $casino = session('casino_actual', 'Casino Norte');

        MenuItem::where('fecha', $fecha)
                ->where('casino', $casino)
                ->delete();

        return redirect()->route('menu.index')->with('success', 'Menú eliminado.');
    }

    public function edit($fecha)
    {
        $casino = session('casino_actual', 'Casino Norte');
        $items = MenuItem::where('fecha', $fecha)
                         ->where('casino', $casino)
                         ->get();

        return view('menu.edit', compact('items', 'fecha', 'casino'));
    }

    public function update(Request $request, $fecha)
    {
        $casino = session('casino_actual', 'Casino Norte');

        $request->validate([
            'items.*.nombre' => 'required|string',
            'items.*.precio' => 'required|numeric',
        ]);

        // Eliminar platos eliminados por el usuario
        $idsEnviados = collect($request->items)->pluck('id')->filter();
        MenuItem::where('fecha', $fecha)
                ->where('casino', $casino)
                ->whereNotIn('id', $idsEnviados)
                ->delete();

        // Crear o actualizar cada ítem
        foreach ($request->items as $item) {
            MenuItem::updateOrCreate(
                ['id' => $item['id'] ?? null],
                [
                    'nombre' => $item['nombre'],
                    'descripcion' => $item['descripcion'] ?? '',
                    'precio' => $item['precio'],
                    'fecha' => $fecha,
                    'casino' => $casino
                ]
            );
        }

        return redirect()->route('menu.index')->with('success', 'Menú actualizado.');
    }
}