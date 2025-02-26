<?php

use Illuminate\Support\Facades\Route;
use App\Filament\Resources\ProjectResource\Pages\EditProject;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/projects/{project:slug}/edit', [EditProject::class, 'edit'])->name('projects.edit');
