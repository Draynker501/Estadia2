<?php

use App\Filament\Resources\ProjectResource\Pages\ReviewProject;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Agrega una ruta personalizada para manejar el envío del formulario de marcar el checklist como completado
Route::post('/projects/{record}/review/mark-checklist', [ReviewProject::class, 'markChecklistAsCompleted'])
    ->name('filament.resources.project-resource.review.mark-checklist');
