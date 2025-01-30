<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Lista de permisos
        $permissions = [
            'Crear cliente',
            'Editar cliente',
            'Ver cliente',
            'Eliminar cliente',
            'Ninguno',
        ];

        // Insertar permisos si no existen
        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web',
            ]);
        }

        // Lista de roles
        $roles = [
            'Super Admin' => $permissions, // Le damos todos los permisos
            'Administrador' => ['Crear cliente', 'Editar cliente', 'Ver cliente', 'Eliminar cliente'],
            'Editor' => ['Editar cliente', 'Ver cliente', 'Crear cliente'],
            'Autor' => ['Editar cliente', 'Ver cliente', 'Crear cliente'],
            'Subscriptor' => ['Ninguno'],
        ];

        // Insertar roles y asignar permisos
        foreach ($roles as $roleName => $rolePermissions) {
            $role = Role::firstOrCreate([
                'name' => $roleName,
                'guard_name' => 'web',
            ]);

            // Asignar permisos al rol
            $role->syncPermissions($rolePermissions);
        }
    }
}
