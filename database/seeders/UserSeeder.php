<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Hash;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear 10 usuarios con rol Subscriptor
        $subscriberRole = Role::where('name', 'Subscriptor')->first();

        if (!$subscriberRole) {
            $this->command->warn("El rol 'Subscriptor' no existen en la base de datos.");
            return;
        }

        // 5 usuarios con email_verified_at
        User::factory(5)->create()->each(function ($user) use ($subscriberRole) {
            $user->roles()->attach($subscriberRole);
        });

        // 5 usuarios sin email_verified_at
        User::factory(5)->unverified()->create()->each(function ($user) use ($subscriberRole) {
            $user->roles()->attach($subscriberRole);
        });
    }
}
