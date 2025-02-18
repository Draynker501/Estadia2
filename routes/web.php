<?php

use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectChecklistRelController;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/project-checklist/{check}/mark', [ProjectChecklistRelController::class, 'markCheck'])->name('project-checklist.check');

Route::post('/project-checklist/{id}/update-checks', [ProjectChecklistRelController::class, 'updateChecks'])
    ->name('project-checklist.updateChecks');

Route::get('/project-checklist/{id}/pdf', [ProjectChecklistRelController::class, 'descargarPDF'])
    ->name('project-checklist.pdf');

Route::post('/project-checklist/{id}/email', [ProjectChecklistRelController::class, 'enviarPDFPorCorreo'])
    ->name('project-checklist.email');