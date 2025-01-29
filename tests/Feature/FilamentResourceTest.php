<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Customer;
use Spatie\Permission\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

class FilamentResourceTest extends TestCase
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

    /** @test */
    public function administrador_puede_administrar_customers()
    {
        $role = Role::create(['name' => 'Administrador']);

        // Crear un usuario y asignar el rol
        $user = User::factory()->create();
        $user->assignRole($role);

        $this->actingAs(user: $user);

        // Ver formulacio de creación de customer
        $response = $this->get(uri: '/admin/customers/create');
        $response->assertStatus(200);

        $this->post('/admin/customers', [
            'name' => 'Cliente de prueba',
            'email' => 'cliente@ejemplo.com',
        ])
        ->assertRedirect('/admin/customers');
        
        $this->assertDatabaseHas('customers', [
            'name' => 'Cliente de prueba',
            'email' => 'cliente@ejemplo.com',
        ]);
        // // Crear un customer
        // $response = $this->post('/livewire/update/', [
        //     'name' => 'Cliente de prueba',
        //     'email' => 'cliente@ejemplo.com',
        //     'user_id' => $user->id
        // ]);
        // $response->assertStatus(200); // Cliente creado exitosamente


        // // Obtener el ID del customer creado de la respuesta
        // $customerId = $response->json('id');  // Ajusta esto si el ID está en un lugar diferente

        // // Ver customer
        // $response = $this->get("/admin/customers/{$customerId}"); // Usar el ID dinámicamente
        // $response->assertStatus(200);

        // // Formulario de edición de customer
        // $response = $this->get(uri: "/admin/customers/{$customerId}/edit");
        // $response->assertStatus(200);

        // // Editar customer
        // $response = $this->post("/livewire/update/", [
        //     'name' => 'Cliente Editado',
        //     'email' => 'clienteeditado@ejemplo.com'
        // ]);
        // $response->assertStatus(200);

        // // Eliminar customer
        // $response = $this->delete("/admin/customers/{$customerId}");
        // $response->assertStatus(200);
    }

}
