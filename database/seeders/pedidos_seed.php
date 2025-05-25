<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class pedidos_seed extends Seeder
{
     public function run(): void
    {
        DB::table('pedidos')->insert([
            [
                'nombre' => 'Estudiante 1',
                'menu' => 'Arroz con pollo',
                'fecha' => Carbon::now()->toDateString(),
                'hora' => Carbon::now()->format('H:i'),
                'nota_cliente' => 'Sin cebolla, por favor',
                'estado' => 'Listo para retirar',
                'casino' => 'Casino norte',
            ],
            [
                'nombre' => 'Funcionario 1',
                'menu' => 'Lasagna',
                'fecha' => Carbon::now()->toDateString(),
                'hora' => Carbon::now()->format('H:i'),
                'nota_cliente' => 'Sin gluten, por favor',
                'estado' => 'En Preparación',
                'casino' => 'Casino sur',
            ],
            [
                'nombre' => 'Funcionario 2',
                'menu' => 'Lasagna',
                'fecha' => Carbon::now()->toDateString(),
                'hora' => Carbon::now()->format('H:i'),
                'nota_cliente' => 'Sin aceitunas, por favor',
                'estado' => 'Entregado',
                'casino' => 'Casino teplinsky',
            ],
            [
                'nombre' => 'Estudiante 2',
                'menu' => 'Hipocálorico',
                'fecha' => Carbon::now()->toDateString(),
                'hora' => Carbon::now()->format('H:i'),
                'nota_cliente' => 'Sin aceitunas, por favor',
                'estado' => 'Cancelado',
                'casino' => 'Casino sur',
            ],
        ]);
    }
}
