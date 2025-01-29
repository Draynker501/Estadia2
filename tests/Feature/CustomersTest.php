<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Customer;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CustomersTest extends TestCase
{
    use RefreshDatabase;


    /** @test */
    public function administrador_puede_crear_customers()
    {
        $role = Role::create(['name' => 'Administrador']);

        // Crear un usuario y asignar el rol
        $user = User::factory()->create();
        $user->assignRole($role);

        $this->actingAs(user: $user);

        // Ver formulacio de creación de customer
        $response = $this->get(uri: '/admin/customers/create');
        $response->assertStatus(200);

        // Crear un customer
        $response = $this->post('/livewire/update/', [
            'name' => 'Cliente de prueba',
            'email' => 'cliente@ejemplo.com',
            'user_id' => $user->id
        ]);
        $response->assertStatus(200); // Cliente creado exitosamente
    }

    public function administrador_puede_ver_customers()
    {
        $role = Role::create(['name' => 'Administrador']);

        // Crear un usuario y asignar el rol
        $user = User::factory()->create();
        $user->assignRole($role);

        $this->actingAs(user: $user);

        // Crear el customer manualmente en la base de datos
        $customer = Customer::factory()->create([
            'name' => 'Cliente de prueba',
            'email' => 'cliente@ejemplo.com',
            'user_id' => $user->id
        ]);

        // Obtener el ID real del registro creado
        $customerId = $customer->id;

        // Ver customer
        $response = $this->get("/admin/customers/{$customerId}");
        $response->assertStatus(200);
    }

    public function administrador_puede_editar_customers()
    {
        $role = Role::create(['name' => 'Administrador']);

        // Crear un usuario y asignar el rol
        $user = User::factory()->create();
        $user->assignRole($role);

        $this->actingAs(user: $user);

        // Crear el customer manualmente en la base de datos
        $customer = Customer::factory()->create([
            'name' => 'Cliente de prueba',
            'email' => 'cliente@ejemplo.com',
            'user_id' => $user->id
        ]);

        // Obtener el ID real del registro creado
        $customerId = $customer->id;

        // Formulario de edición de customer
        $response = $this->get("/admin/customers/{$customerId}/edit");
        $response->assertStatus(200);

        // Editar customer
        $response = $this->post("/livewire/update/", [
            'id' => $customerId, // Asegurar que enviamos el ID correcto
            'name' => 'Cliente Editado',
            'email' => 'clienteeditado@ejemplo.com'
        ]);
        $response->assertStatus(200);
    }

    public function administrador_puede_eliminar_customers()
    {
        $role = Role::create(['name' => 'Administrador']);

        // Crear un usuario y asignar el rol
        $user = User::factory()->create();
        $user->assignRole($role);

        $this->actingAs(user: $user);

        // Crear el customer manualmente en la base de datos
        $customer = Customer::factory()->create([
            'name' => 'Cliente de prueba',
            'email' => 'cliente@ejemplo.com',
            'user_id' => $user->id
        ]);

        // Obtener el ID real del registro creado
        $customerId = $customer->id;

        // Eliminar customer
        $response = $this->post('/livewire/update/', [
            'id' => $customerId,
            'action' => 'delete',
        ]);
        $response->assertStatus(200);
    }
}
