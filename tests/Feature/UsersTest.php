<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Spatie\Permission\Models\Role;

class UsersTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function super_admin_puede_crear_users()
    {
        $role = Role::create(['name' => 'Super Admin']);

        // Crear un usuario y asignar el rol
        $user = User::factory()->create();
        $user->assignRole($role);

        $this->actingAs(user: $user);

        // Ver formulacio de creación de newUser
        $response = $this->get(uri: '/admin/users/create');
        $response->assertStatus(200);

        // Crear un newUser
        $response = $this->post('/livewire/update/', [
            'name' => 'user de prueba',
            'email' => 'user@ejemplo.com',
        ]);
        $response->assertStatus(200);
    }

    /** @test */
    public function super_admin_puede_ver_users()
    {
        $role = Role::create(['name' => 'Super Admin']);

        // Crear un usuario y asignar el rol
        $user = User::factory()->create();
        $user->assignRole($role);

        $this->actingAs(user: $user);

        // Crear el newUser manualmente en la base de datos
        $newUser = User::factory()->create([
            'name' => 'User de prueba',
            'email' => 'user@ejemplo.com',
        ]);

        // Obtener el ID real del registro creado
        $newUserId = $newUser->id;

        // Ver newUser
        $response = $this->get("/admin/users/{$newUserId}");
        $response->assertStatus(200);
    }

    /** @test */
    public function super_admin_puede_editar_users()
    {
        $role = Role::create(['name' => 'Super Admin']);

        // Crear un usuario y asignar el rol
        $user = User::factory()->create();
        $user->assignRole($role);

        $this->actingAs(user: $user);

        // Crear el User manualmente en la base de datos
        $newUser = User::factory()->create([
            'name' => 'User de prueba',
            'email' => 'user@ejemplo.com',
        ]);

        // Obtener el ID real del registro creado
        $newUserId = $newUser->id;

        // Formulario de edición de newUser
        $response = $this->get("/admin/users/{$newUserId}/edit");
        $response->assertStatus(200);

        // Editar newUser
        $response = $this->post("/livewire/update/", [
            'id' => $newUserId, // Asegurar que enviamos el ID correcto
            'name' => 'Usuario Editado',
            'email' => 'usuarioeditado@ejemplo.com'
        ]);
        $response->assertStatus(200);
    }

    /** @test */
    public function super_admin_puede_eliminar_users()
    {
        $role = Role::create(['name' => 'Super Admin']);

        // Crear un usuario y asignar el rol
        $user = User::factory()->create();
        $user->assignRole($role);

        $this->actingAs(user: $user);

        // Crear el newUser manualmente en la base de datos
        $newUser = User::factory()->create([
            'name' => 'User de prueba',
            'email' => 'user@ejemplo.com',
        ]);

        // Obtener el ID real del registro creado
        $newUserId = $newUser->id;

        // Eliminar newUser
        $response = $this->post('/livewire/update/', [
            'id' => $newUserId,
            'action' => 'delete',
        ]);
        $response->assertStatus(200);
    }

    /** @test */
    public function usuario_sin_rol_super_admin_no_tiene_acceso_a_modulo_users()
    {
        Role::create(['name' => 'Super Admin']);
        $role = Role::create(['name' => 'Administrador']);

        // Crear un usuario y asignar el rol
        $user = User::factory()->create();
        $user->assignRole($role);

        $this->actingAs(user: $user);

        // Intenta acceder al modulo de customers
        $response = $this->get("/admin/users");
        $response->assertStatus(403);
    }
}
