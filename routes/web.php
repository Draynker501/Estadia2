<?php

use Illuminate\Support\Facades\Route;
use App\Filament\Resources\ProjectResource\Pages\EditProject;
use App\Models\File;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/projects/{project:slug}/edit', [EditProject::class, 'edit'])->name('projects.edit');

Route::get('/files/download/{file}', fn(File $file) => $file->download())->name('files.download');
