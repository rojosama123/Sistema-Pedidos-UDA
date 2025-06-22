<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Review;
use App\Models\User;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        // Crea algunos usuarios si no hay
        if (User::count() === 0) {
            User::factory()->count(10)->create();
        }

        $casinos = ['Casino Norte', 'Casino Sur', 'Casino Teplinsky'];
        $comentarios = [
            'Excelente comida, muy sabrosa.',
            'El menú de hoy estuvo bien.',
            'La atención fue rápida y cordial.',
            'Poca variedad en el menú.',
            'Muy mala experiencia, todo frío.',
            'El postre fue lo mejor del día.',
            'Buena relación calidad-precio.',
            'Demasiada espera para recibir el pedido.',
            'El arroz estaba duro.',
            'Volvería a comer aquí sin dudas.',
            'No tenían lo que quería pedir.',
            'La carne estaba seca.',
            'Muy buena presentación de los platos.',
            'Me encantó el jugo natural.',
            'El personal fue muy amable.',
        ];

        // Obtener los IDs de usuarios existentes
        $userIds = User::pluck('id');

        // Crear 50 reseñas con usuarios reales
        foreach (range(1, 50) as $i) {
            Review::create([
                'user_id'     => $userIds->random(),
                'comentario'  => $comentarios[array_rand($comentarios)],
                'calificacion'=> rand(1, 5),
                'casino'      => $casinos[array_rand($casinos)],
                'created_at'  => now()->subDays(rand(0, 30)),
            ]);
        }
    }
}