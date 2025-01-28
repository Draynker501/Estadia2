<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\User;
use App\Models\Customer;
use App\Models\Role;
use App\Models\Permission;
use App\Policies\UserPolicy;
use App\Policies\RolePolicy;
use App\Policies\CustomerPolicy;
use App\Policies\PermissionPolicy;
use Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        User::class => UserPolicy::class,
        Role::class => RolePolicy::class,
        Customer::class => CustomerPolicy::class,
        Permission::class => PermissionPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        // Definir el Gate para Filament
        Gate::define('access-filament', function (User $user) {
            return $user->hasRole('Super Admin') || $user->hasRole('Administrador');
        });
    }
}
