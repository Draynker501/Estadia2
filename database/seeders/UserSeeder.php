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
        // Crear 10 usuarios con rol Subscriptor y permiso Ninguno
        $subscriberRole = Role::where('name', 'Subscriptor')->first();
        $nonePermission = Permission::where('name', 'Ninguno')->first();

        if (!$subscriberRole || !$nonePermission) {
            $this->command->warn("El rol 'Subscriptor' o el permiso 'Ninguno' no existen en la base de datos.");
            return;
        }

        // 5 usuarios con email_verified_at
        User::factory(5)->create()->each(function ($user) use ($subscriberRole, $nonePermission) {
            $user->roles()->attach($subscriberRole);
            $user->permissions()->attach($nonePermission);
        });

        // 5 usuarios sin email_verified_at
        User::factory(5)->unverified()->create()->each(function ($user) use ($subscriberRole, $nonePermission) {
            $user->roles()->attach($subscriberRole);
            $user->permissions()->attach($nonePermission);
        });
    }
}
