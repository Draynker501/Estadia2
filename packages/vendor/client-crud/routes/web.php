<?php
use Illuminate\Support\Facades\Route;
use Vendor\ClientCrud\Resources\ClientResource;
use Filament\Facades\Filament;

Route::middleware(['web'])
    ->prefix('admin')
    ->group(function () {
        Filament::registerResources([
            ClientResource::class,
        ]);
    });
