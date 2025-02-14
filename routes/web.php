<?php

use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectChecklistController;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/project-checklist/{check}/mark', [ProjectChecklistController::class, 'markCheck'])->name('project-checklist.check');

Route::post('/project-checklist/{id}/update-checks', [ProjectChecklistController::class, 'updateChecks'])
    ->name('project-checklist.updateChecks');

Route::get('/project-checklist/{id}/pdf', [ProjectChecklistController::class, 'descargarPDF'])
    ->name('project-checklist.pdf');

Route::post('/project-checklist/{id}/email', [ProjectChecklistController::class, 'enviarPDFPorCorreo'])
    ->name('project-checklist.email');