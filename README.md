# Pasos para dejar funcionando el proyecto

## Requisitos previos

- Tener instalado **Laragon** o un entorno de desarrollo similar.
- PHP 8.1 o superior.
- Composer instalado.

---

## Instrucciones

### 1. Crear proyecto Laravel

```bash
laravel new nombre-del-proyecto --version=10
```

### 2. Instalar Filament

```bash
composer require filament/filament -W
```

### 3. Instalar paneles

```bash
php artisan filament:install --panels
```

### 4. Crear modelos

Crear los modelos `Customer`, `Role` y `Permission`.

### 5. Crear y modificar migraciones

- Para el modelo `Customer`, agregar los siguientes atributos:
  - `user_id` (clave foránea)
  - `name`
  - `last_name`
  - `phone`
  - `email`
  - `status`
- Agregar el atributo `send_notification` (boolean) a la migración de `users`.

### 6. Configurar base de datos

Cambiar el nombre de la base de datos en el archivo `.env` y ejecutar las migraciones:

```bash
php artisan migrate
```

### 7. Crear usuario administrador

```bash
php artisan make:filament-user
```

### 8. Agregar método para recuperación de contraseña

En el archivo `AdminPanelProvides.php`, agregar el método `passwordReset()` para habilitar la opción de recuperación de contraseña.

### 9. Configurar correo electrónico

Configurar los valores relacionados con MAIL en el archivo `.env`.

### 10. Generar CRUDs

```bash
php artisan make:filament-resource nombre-del-modelo --generate
```

### 11. Instalar paquete Spatie

```bash
composer require spatie/laravel-permission
```

### 12. Publicar migraciones y configuración

```bash
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"
```

### 13. Agregar trait al modelo User

Agregar el trait `HasRoles` al modelo `User`.

### 14. Implementar interfaz FilamentUser en User

En el modelo `User`, implementar la interfaz `FilamentUser` y agregar el siguiente método:

```php
public function canAccessPanel(Panel $panel): bool
{
    return $this->hasRole(['Super Admin', 'Administrador', 'Editor', 'Autor', 'Colaborador', 'Subscriptor']);
}
```

### 15. Modificar UserResource.php

Modificar el archivo `UserResource.php` para que utilice los registros de `Role` y `Permission`. También, agregar un checkbox para el atributo `send_notification`.

### 16. Crear Policies

```bash
php artisan make:policy nombre-del-modelo-Policy --model=nombre-del-modelo
```
Ejemplo:
```bash
php artisan make:policy UserPolicy --model=User
```

### 17. Configurar métodos en Policies

Ejemplo para limitar acceso:

```php
public function create(User $user): bool
{
    return $user->hasRole(['Super Admin', 'Administrador']) || $user->hasPermissionTo('Crear cliente');
}
```

### 18. Registrar políticas en AuthServiceProvider

En el archivo `AuthServiceProvider.php`, agregar:

```php
protected $policies = [
    User::class => UserPolicy::class,
    Role::class => RolePolicy::class,
    Customer::class => CustomerPolicy::class,
    Permission::class => PermissionPolicy::class,
];
```

### 19. Crear notificaciones

```bash
php artisan make:notification nombre-del-modelo-accion-Notification
```
Ejemplo:
```bash
php artisan make:notification UserDeletedNotification
```

### 20. Modificar mensajes de notificaciones

Personalizar el contenido de cada notificación según sea necesario.

### 21. Agregar notificaciones a acciones

#### 21.1 En `CreateUser.php`

```php
protected function afterCreate(): void
{
    if ($this->record->send_notification) {
        $this->record->notify(new WelcomeUserNotification());
    }
}
```

#### 21.2 En `EditUser.php`

```php
protected function afterSave(): void
{
    if ($this->record->send_notification) {
        $this->record->notify(new UserUpdatedNotification());
    }
}
```

#### 21.3 En el modelo User

```php
protected static function boot()
{
    parent::boot();

    static::deleting(function ($user) {
        if ($user->send_notification) {
            $user->notify(new UserDeletedNotification());
        }
    });
}
```

### 22. Modal de confirmación para actualizar registros

Agregar el siguiente método en todos los CRUDs:

```php
protected function getSaveFormAction(): Actions\Action
{
    return parent::getSaveFormAction()
        ->submit(form: null)
        ->requiresConfirmation()
        ->action(function () {
            $this->closeActionModal();
            $this->save();
        });
}
```

### 23. Crear factories y seeders

```bash
php artisan make:factory nombre-del-modelo --model=nombre-del-modelo
php artisan make:seeder nombre-del-modelo-Seeder
```
Ejemplo:
```bash
php artisan make:factory UserFactory --model=User
php artisan make:seeder UserSeeder
```

### 24. Configurar factories

Configurar reglas para los registros en los factories de `users` y `customers`.

### 25. Configurar seeders

#### 25.1 Seeder de `users`

Crear 10 usuarios colaboradores:
- 5 con `email_verified_at`.
- 5 sin `email_verified_at`.

#### 25.2 Seeder de `customers`

Crear 50 clientes:
- 25 con `status` Activo.
- 25 con `status` Inactivo.
