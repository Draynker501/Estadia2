<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener el primer usuario disponible
        $userId = User::first()->id; // O puedes usar cualquier lógica para obtener un usuario específico

        // Crear 25 clientes con status 'activo'
        Customer::factory(25)->state([
            'user_id' => $userId, // Asigna el ID de usuario obtenido
            'status' => 'Activo',
        ])->create();

        // Crear 25 clientes con status 'inactivo'
        Customer::factory(25)->state([
            'user_id' => $userId, // Asigna el ID de usuario obtenido
            'status' => 'Inactivo',
        ])->create();
    }
}
