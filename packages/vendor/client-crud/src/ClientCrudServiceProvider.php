<?php

namespace Vendor\ClientCrud;

use Filament\PluginServiceProvider;
use Spatie\LaravelPackageTools\Package;

class ClientCrudServiceProvider extends PluginServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('client-crud')
            ->hasRoutes('web')
            ->hasMigrations(['create_clients_table']);
    }
}
