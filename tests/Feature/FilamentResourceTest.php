<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FilamentResourceTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function authenticated_users_with_proper_roles_can_access_filament_dashboard()
    {
        // Crear permisos
        $permission = Permission::create(['name' => 'Ver customers']);

        // Crear un rol y asignar permisos al rol
        $role = Role::create(['name' => 'admin']);
        $role->givePermissionTo($permission);

        // Crear un usuario y asignar el rol
        $user = User::factory()->create([
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
        ]);
        $user->assignRole($role);

        // Actuar como el usuario
        $this->actingAs($user);

        // Acceder al dashboard de Filament
        $response = $this->get('/admin');

        // Verificar que el usuario tiene acceso
        $response->assertStatus(200);
        $response->assertSee('Dashboard'); // Ajusta el texto según tu vista
    }

    /** @test */
    public function users_without_proper_roles_cannot_access_filament_dashboard()
    {
        // Crear un usuario sin permisos
        $user = User::factory()->create();

        // Actuar como el usuario
        $this->actingAs($user);

        // Intentar acceder al dashboard de Filament
        $response = $this->get('/admin');

        // Verificar que el acceso está prohibido
        $response->assertStatus(403);
    }
}
