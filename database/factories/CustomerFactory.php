<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Customer::class;

    public function definition(): array
    {
        // Obtener IDs de usuarios que no sean Subscriptor y no tengan el permiso Ninguno
        $validUserIds = User::whereDoesntHave('roles', function ($query) {
            $query->where('name', 'Subscriptor');
        })->whereDoesntHave('permissions', function ($query) {
            $query->where('name', 'Ninguno');
        })->pluck('id');
        
        return [
            'name' => substr($this->faker->firstName, 0, 20),
            'last_name' => substr($this->faker->lastName, 0, 30),
            'email' => substr($this->faker->unique()->safeEmail, 0, 50),
            'phone' => substr($this->faker->numerify('### ### ### ####'), 0, 15),
            'status' => $this->faker->boolean(), // Generar booleano
            'user_id' => $this->faker->randomElement($validUserIds->toArray()), // Selecciona un ID válido aleatoriamente
        ];

    }
}
