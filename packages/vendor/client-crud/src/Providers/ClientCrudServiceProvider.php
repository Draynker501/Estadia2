<?php

namespace Vendor\ClientCrud\Providers;

use Illuminate\Support\ServiceProvider;
use Vendor\Crud\Filament\Resources\ClientResource;
use Filament\Facades\Filament;

class ClientCrudServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // Cargar migraciones
        $this->publishes([
            __DIR__ . '/../database/migrations' => database_path('migrations'),
        ], 'crud-migrations');

        // Publicar el recurso de Filament
        $this->publishes([
            __DIR__ . '/../../src/Filament/Resources/ClientResource.php' => app_path('Filament/Resources/ClientResource.php'),
            __DIR__ . '/../../src/Filament/Resources/ClientResource/Pages' => app_path('Filament/Resources/ClientResource/Pages'),
        ], 'crud-resource');
    }
}