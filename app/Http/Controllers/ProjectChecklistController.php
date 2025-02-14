<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;
use App\Models\CheckStatus;
use App\Models\ProjectChecklist;
use App\Models\Check;

class ProjectChecklistController extends Controller
{
    public function markCheck(Request $request, $checkId)
    {
        $check = Check::findOrFail($checkId);
        $projectChecklistId = $request->input('project_checklist_id');

        // Actualizar o crear el estado del check en CheckStatus
        $checkStatus = CheckStatus::updateOrCreate(
            [
                'project_checklist_id' => $projectChecklistId,
                'check_id' => $checkId
            ],
            [
                'checked' => $request->has('checked') // Se marca como true o false dependiendo de si viene en la request
            ]
        );

        // Obtener los IDs de los checks obligatorios para este checklist
        $requiredCheckIds = Check::where('checklist_id', $check->checklist_id)
            ->where('required', true)
            ->pluck('id')
            ->toArray();

        // Contar cuántos de los checks obligatorios están marcados en CheckStatus
        $checkedRequiredChecks = CheckStatus::where('project_checklist_id', $projectChecklistId)
            ->whereIn('check_id', $requiredCheckIds)
            ->where('checked', true)
            ->count();

        // Marcar el checklist como completado solo si todos los obligatorios están marcados
        $allRequiredChecked = $checkedRequiredChecks === count($requiredCheckIds);

        ProjectChecklist::where('id', $projectChecklistId)
            ->update(['completed' => $allRequiredChecked]);

        return back();
    }

    public function updateChecks(Request $request, $projectChecklistId)
    {
        $projectChecklist = ProjectChecklist::findOrFail($projectChecklistId);

        // Obtener los checks enviados desde el formulario
        $checks = $request->input('checks', []);

        foreach ($checks as $checkId => $value) {
            CheckStatus::updateOrCreate(
                [
                    'project_checklist_id' => $projectChecklist->id,
                    'check_id' => $checkId
                ],
                [
                    'checked' => (bool) $value // Convertir el valor a booleano
                ]
            );
        }

        // Obtener IDs de checks requeridos y todos los checks en el checklist
        $checklistId = $projectChecklist->checklist_id;
        $requiredCheckIds = Check::where('checklist_id', $checklistId)
            ->where('required', true)
            ->pluck('id')
            ->toArray();

        $allCheckIds = Check::where('checklist_id', $checklistId)
            ->pluck('id')
            ->toArray();

        // Contar cuántos de estos están marcados en CheckStatus
        $checkedRequiredChecks = CheckStatus::where('project_checklist_id', $projectChecklistId)
            ->whereIn('check_id', $requiredCheckIds)
            ->where('checked', true)
            ->count();

        $checkedAllChecks = CheckStatus::where('project_checklist_id', $projectChecklistId)
            ->whereIn('check_id', $allCheckIds)
            ->where('checked', true)
            ->count();

        // Condición corregida: se completa si (todos los requeridos) o (todos en total) están marcados
        $allRequiredChecked = $checkedRequiredChecks === count($requiredCheckIds);
        $allChecksChecked = $checkedAllChecks === count($allCheckIds);

        $projectChecklist->update(['completed' => $allRequiredChecked || $allChecksChecked]);

        return redirect()->back()->with('success', 'Los cambios se han guardado correctamente.');
    }

    public function descargarPDF($id)
    {
        $record = Project::with('projectChecklists.checklist.checks.checkStatuses')->findOrFail($id);

        // Reemplazar espacios y caracteres especiales en el nombre del archivo
        $fileName = str_replace([' ', '/'], '-', $record->name) .'.pdf';

        $pdf = app('dompdf.wrapper')->loadView('pdf.project_checklist', compact('record'));

        return $pdf->download($fileName);
    }

}
