<?php
use Illuminate\Support\Facades\Route;
use Filament\Facades\Filament;

Route::middleware(['web', 'auth'])
    ->prefix('admin')
    ->group(function () {
        Filament::routes();
    });
