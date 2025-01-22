<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    public function run(): void
    {
        // Obtener los IDs de los usuarios válidos (sin rol 'Subscriptor' ni permiso 'Ninguno')
        $validUserIds = User::whereDoesntHave('roles', function ($query) {
            $query->where('name', 'Subscriptor');
        })->whereDoesntHave('permissions', function ($query) {
            $query->where('name', 'Ninguno');
        })->pluck('id');

        // Verificar que haya usuarios válidos
        if ($validUserIds->isEmpty()) {
            throw new \Exception('No hay usuarios válidos disponibles para asignar como user_id.');
        }

        // Crear 25 clientes con status 'Activo' y asignar un user_id válido aleatoriamente
        Customer::factory(25)->create([
            'user_id' => $validUserIds->random(),
            'status' => true, // Activo (1)
        ]);

        // Crear 25 clientes con status 'Inactivo' y asignar un user_id válido aleatoriamente
        Customer::factory(25)->create([
            'user_id' => $validUserIds->random(),
            'status' => false, // Inactivo (0)
        ]);
    }
}
