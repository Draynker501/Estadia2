<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

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
        $userId = 1; // Aseguramos que user_id siempre se asigna
        return [
            'name' => substr($this->faker->firstName, 0, 20),
            'last_name' => substr($this->faker->lastName, 0, 30),
            'email' => substr($this->faker->unique()->safeEmail, 0, 50),
            'phone' => substr($this->faker->numerify('### ### ### ####'), 0, 15),
            'status' => substr($this->faker->randomElement(['Activo', 'Inactivo']), 0, 15),
            'user_id' => $userId,
        ];

    }
}
