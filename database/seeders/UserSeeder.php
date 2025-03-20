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
        // Crear usuario SuperAdmin con rol Super Admin
        $superAdminRole = Role::where('name', 'Super Admin')->first();

        if (!$superAdminRole) {
            $this->command->warn("El rol 'Super Admin' no existe en la base de datos.");
            return;
        }

        // Crear el SuperAdmin con correo y contraseña superadmin@gmail.com
        $superAdmin = User::create([
            'name' => 'Super Admin',
            'email' => 'super@admin.com',
            'password' => bcrypt('1234@'),
            'email_verified_at' => now(),
        ]);

        // Asignar el rol Super Admin al usuario SuperAdmin
        $superAdmin->assignRole($superAdminRole);

        // Crear usuario Administrador con rol Administrador
        $adminRole = Role::where('name', 'Administrador')->first();

        if (!$adminRole) {
            $this->command->warn("El rol 'Administrador' no existe en la base de datos.");
            return;
        }

        $admin = User::create([
            'name' => 'Administrador',
            'email' => 'administrador@gmail.com',
            'password' => bcrypt('administrador@gmail.com'),
            'email_verified_at' => now(),
        ]);

        $admin->assignRole($adminRole);

        // Crear usuario Editor con rol Editor
        $editRole = Role::where('name', 'Editor')->first();

        if (!$editRole) {
            $this->command->warn("El rol 'Editor' no existe en la base de datos.");
            return;
        }

        $editor = User::create([
            'name' => 'Editor',
            'email' => 'editor@gmail.com',
            'password' => bcrypt('editor@gmail.com'),
            'email_verified_at' => now(),
        ]);

        $editor->assignRole($editRole);

        // Crear usuario Autor con rol Autor
        $autorRole = Role::where('name', 'Autor')->first();

        if (!$autorRole) {
            $this->command->warn("El rol 'Autor' no existe en la base de datos.");
            return;
        }

        $autor = User::create([
            'name' => 'Autor',
            'email' => 'autor@gmail.com',
            'password' => bcrypt('autor@gmail.com'),
            'email_verified_at' => now(),
        ]);

        $autor->assignRole($autorRole);

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
