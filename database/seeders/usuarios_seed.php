<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class usuarios_seed extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'nombre' => 'Esteban Estudiante',
                'rut' => '12345678-9',
                'email' => 'estudiante@uda.cl',
                'password' => Hash::make('12345678'),
                'tipo_usuario' => 'estudiante',
                'remember_token' => null,
            ],
            [
                'nombre' => 'Felipe Funcionario',
                'rut' => '98765432-1',
                'email' => 'funcionario@uda.cl',
                'password' => Hash::make('12345678'),
                'tipo_usuario' => 'funcionario',
                'remember_token' => null,
            ],
            [
                'nombre' => 'Carmen Casino',
                'rut' => '11111111-1',
                'email' => 'casino@uda.cl',
                'password' => Hash::make('12345678'),
                'tipo_usuario' => 'casino',
                'remember_token' => null,
            ],
        ]);
    }
}