<?php

namespace Vendor\ClientCrud;

use Filament\Panel;
use Illuminate\Support\ServiceProvider;
use Filament\Resources\Resource;
use Filament\Forms;
use Filament\Tables;
use Spatie\LaravelPackageTools\Package;
use Vendor\ClientCrud\Resources\ClientResource;
use Filament\Facades\Filament;

class ClientCrudServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Puedes registrar cualquier cosa aquí si es necesario
    }

    public function boot()
    {
        // Registra recursos, rutas, migraciones, etc.
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

    Filament::serving(function () {
        Filament::registerPanelResources(Panel::ADMIN, [
            ClientResource::class,
        ]);
    });

    }

    public function configurePackage(Package $package): void
    {
        $package
            ->name('client-crud')
            ->hasMigrations(['2025_01_14_155632_create_clients_table']);
    }
}
