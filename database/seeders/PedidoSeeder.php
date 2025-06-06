<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pedido;
use App\Models\PedidoDetalle;
use Illuminate\Support\Carbon;

class PedidoSeeder extends Seeder
{
    public function run()
    {
        $faker = \Faker\Factory::create();

        $casinos = ['Casino Norte', 'Casino Sur', 'Casino Teplinsky'];
        $estados = ['Entregado', 'En Preparación', 'Listo para retirar', 'Cancelado'];

        foreach (range(1, 30) as $i) {
            $pedido = Pedido::create([
                'nombre' => $faker->name,
                'fecha' => Carbon::today()->format('Y-m-d'),
                'hora' => $faker->time('H:i'),
                'estado' => $faker->randomElement($estados),
                'casino' => $faker->randomElement($casinos),
            ]);

            // Añadir de 1 a 4 platos por pedido
            $numPlatos = rand(1, 4);
            for ($j = 0; $j < $numPlatos; $j++) {
                PedidoDetalle::create([
                    'pedido_id' => $pedido->id,
                    'plato' => $faker->randomElement([
                        'Lasaña de carne', 'Pollo al curry', 'Ensalada César', 'Sopa de lentejas',
                        'Fideos al pesto', 'Cazuela de vacuno', 'Tarta de verduras', 'Empanada de pino'
                    ]),
                    'precio' => $faker->randomFloat(2, 2, 8),
                    'nota_cliente' => $faker->boolean(70) ? $faker->sentence(4) : null,
                ]);
            }
        }
    }
}
