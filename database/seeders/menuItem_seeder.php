<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MenuItem;
use Carbon\Carbon;

class menuItem_seeder extends Seeder
{
    public function run(): void
    {
        $platos = [
            [
                'nombre' => 'Lasaña de carne',
                'descripcion' => 'Lasaña casera con salsa boloñesa y queso gratinado.',
                'precio' => 5200,
                'casino' => 'Casino Norte',
            ],
            [
                'nombre' => 'Pollo al curry',
                'descripcion' => 'Pollo en salsa de curry suave acompañado de arroz.',
                'precio' => 4800,
                'casino' => 'Casino Sur',
            ],
            [
                'nombre' => 'Ensalada César',
                'descripcion' => 'Lechuga, pollo, crutones y aderezo César.',
                'precio' => 3500,
                'casino' => 'Casino Teplinsky',
            ],
            [
                'nombre' => 'Cazuela de vacuno',
                'descripcion' => 'Tradicional cazuela chilena con carne de vacuno y verduras.',
                'precio' => 5400,
                'casino' => 'Casino Norte',
            ],
            [
                'nombre' => 'Tarta de verduras',
                'descripcion' => 'Tarta vegetariana con masa casera y verduras frescas.',
                'precio' => 3900,
                'casino' => 'Casino Sur',
            ],
        ];

        $fechaHoy = Carbon::today()->format('Y-m-d');

        foreach ($platos as $plato) {
            MenuItem::create([
                'nombre' => $plato['nombre'],
                'descripcion' => $plato['descripcion'],
                'precio' => $plato['precio'],
                'fecha' => $fechaHoy,
                'casino' => $plato['casino'],
            ]);
        }
    }
}