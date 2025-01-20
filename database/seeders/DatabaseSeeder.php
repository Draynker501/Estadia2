<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        // \App\Models\User::factory(10)->create();

        $user1 = User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
        ]);
        $user2 = User::factory()->create([
            'name' => 'test',
            'email' => 'test@gmail.com',
        ]);
        $role = Role::create(['name' => 'Super Admin']);
        $user1->assignRole($role);
    }
}
