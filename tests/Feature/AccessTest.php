<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AccessTest extends TestCase
{
    use RefreshDatabase;
    
    /** @test */
    public function usuarios_autenticados_con_roles_adecuados_pueden_acceder_al_dashboard()
    {
        // Crear un rol y asignar permisos al rol
        $role = Role::create(['name' => 'Administrador']);

        // Crear un usuario y asignar el rol
        $user = User::factory()->create();
        $user->assignRole($role);

        // Actuar como el usuario
        $this->actingAs($user);

        // Acceder al dashboard de Filament
        $response = $this->get('/admin');

        // Verificar el acceso
        $response->assertStatus(200);  // Ajusta el texto según tu vista
    }

    /** @test */
    public function usuarios_sin_roles_adecuados_no_pueden_acceder_al_dashboard()
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

    
    /** @test */
    public function super_admin_puede_acceder_a_los_modulos_de_users_permissions_roles_y_customers()
    {
        // Crear un rol
        $role = Role::create(['name' => 'Super Admin']);

        // Crear un usuario y asignar el rol
        $user = User::factory()->create();
        $user->assignRole($role);

        $this->actingAs(user: $user);

        // Acceder al módulo de users
        $response = $this->get('/admin/users');
        $response->assertStatus(200);

        // Acceder al módulo de permissions
        $response = $this->get('/admin/permissions');
        $response->assertStatus(200);

        // Acceder al módulo de roles
        $response = $this->get('/admin/roles');
        $response->assertStatus(200);

        // Acceder al módulo de customers
        $response = $this->get('/admin/customers');
        $response->assertStatus(200);
    }

    /** @test */
    public function usuario_sin_rol_Super_Admin_no_tiene_acceso_a_modulos_users_roles_ni_permissions()
    {
        // Crear un rol
        $role = Role::create(['name' => 'Administrador']);

        // Crear un usuario y asignar el rol
        $user = User::factory()->create();
        $user->assignRole($role);

        $this->actingAs(user: $user);

        // Intentar acceder al módulo de users
        $response = $this->get('/admin/users');
        $response->assertStatus(403); // Acceso prohibido

        // Intentar acceder al módulo de permissions
        $response = $this->get('/admin/permissions');
        $response->assertStatus(403); // Acceso prohibido

        // Intentar acceder al módulo de roles
        $response = $this->get(uri: '/admin/roles');
        $response->assertStatus(403); // Acceso prohibido
    }

}
