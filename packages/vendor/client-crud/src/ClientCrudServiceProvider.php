<?php

namespace Vendor\ClientCrud;

use Illuminate\Support\ServiceProvider;
use Filament\Resources\Resource;
use Filament\Forms;
use Filament\Tables;
use Spatie\LaravelPackageTools\Package;

class ClientCrudServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Puedes registrar cualquier cosa aquí si es necesario
    }

    public function boot()
    {
        // Registra recursos, rutas, migraciones, etc.
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

    }

    public function configurePackage(Package $package): void
    {
        $package
            ->name('client-crud')
            ->hasMigrations(['2014_10_12_000000_create_users_table','2025_01_14_155632_create_clients_table']);
    }
}
