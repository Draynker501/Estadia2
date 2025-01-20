<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear 25 clientes con status 'active'
        Customer::factory(25)->state([
            'status' => 'Activo',
        ])->create();

        // Crear 25 clientes con status 'inactive'
        Customer::factory(25)->state([
            'status' => 'Inactivo',
        ])->create();
    }
}
