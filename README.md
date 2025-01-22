PASOS PARA DEJAR FUNCIONANDO EL PROYECTO

1.- Crear proyecto de laravel en laragon, de preferencia que sea la versión 10 para evitar posibles incompatibilidades.

2.- Instalar filament con el siguiente comando: composer require filament/filament -W.

3.- Instalar paneles con el siguiente comando: php artisan filament:install --panels.

4.- Crear modelos Customer, Role y Permission.

5.- Crear y modificar migración para Customer, debe tener atributos: user_id (clave foranea), name, last_name, phone, email y status. También, agregar atributo send_notification (boolean) a migración de users

6.- Cambiar nombre de la base de datos en .env y ejecutar migración con el comando: php artisan migrate.

7.- Crear un usuario administrador con el comando: php artisan make:filament-user.

8.- Agregar método "passwordReset()" en el archivo "AdminPanelProvides.php" para agregar la opción de recuperar contraseña.

9.- Configurar lo referente a MAIL en .env para que la herramienta de prueba de correo electronico funcione correctamente.

10.- Generar CRUD's de los modelos con el comando: php artisan make:filament-resource nombre-del-modelo --generate.

11.- Instalar paquete spatie con el comando: composer require spatie/laravel-permission

12.- Publicar la migración y el archivo de configuración config/permission.php con: php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"

13.- Agregar trait "HasRoles" al modelo User

14.- Implementar implementar interfaz FilamentUser en el modelo User para después agregar el siguiente método:

public function canAccessPanel(Panel $panel): bool
    {
        return $this->hasRole(['Super Admin','Administrador','Editor','Autor','Colaborador','Subscriptor']);
    }

15.- Modificar el archivo UserResource.php para que haga uso de los registros de Role y Permission, que servirán para limitar sus acciones, además de agregar checkbox para send_notification

16.- Crear Policies para cada CRUD con el comando: php artisan make:policy nombre-del-modelo-Policy (ej. UserPolicy) --model=nombre-del-modelo

17.- Modificar los métodos dentro de los policies creados para limitar el acceso a los CRUD en base a los roles y permisos, ejemplo:

public function create(User $user): bool
    {
        if ($user->hasRole(roles: ['Super Admin', 'Administrador']) || $user->hasPermissionTo('Crear cliente')) {
            return true;
        }
        return false;
    }

18.- Especificar que politica se le aplica a cada modelo en el archivo AuthServiceProvider:
protected $policies = [
        User::class => UserPolicy::class,
        Role::class => RolePolicy::class,
        Customer::class => CustomerPolicy::class,
        Permission::class => PermissionPolicy::class,
    ];

19.- Crear notificaciones para la creación, edición y eliminación de usuario con el comando:
php artisan make:notification nombre-del-modelo-accion-Notification (ejemplo:UserDeletedNotification)

20.- Modificar mensaje según la notificación

21.- Agregar notificaciones a sus acciones:
    21.1.- En el archivo CreateUser.php, agregar método que contiene Notificación de usuario creado:
    protected function afterCreate(): void
    {
        if ($this->record->send_notification) {
            $this->record->notify(new WelcomeUserNotification());
        }
    }

    21.2.- En el archivo EditUser.php, agregar método que contiene Notificación de usuario actualizado:
    protected function afterSave(): void
    {
        if ($this->record->send_notification) {
            $this->record->notify(new UserUpdatedNotification());
        }
    }

    21.3.- En el modelo User, agregar método que contiene Notificación de usuario eliminado:
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($user) {
            if ($user->send_notification) {
                $user->notify(new UserDeletedNotification());
            }
        });
    }

22.- Agregar modal de confirmación para actualizar un registro (todos los CRUD):
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

23.- Crear factories y seeders para users y customers:
php artisan make:factorie nombre-del-modelo --model=nombre-del-modelo 
php artisan make:seeder nombre-del-modelo-Seeder (ejemplo: UserSeeder)

24.- Configurar los factories de users y customers para establecer las reglas que deben seguir los registros

25.- Connfigurar los seeders
    25.1.- users para que cree 10 usuarios colaboradores, 5 con email_verified_at y 5 sin email_verified_at.
    25.2.- customer para que cree 50 clientes, 25 con status Activo y 25 con status Inactivo.

