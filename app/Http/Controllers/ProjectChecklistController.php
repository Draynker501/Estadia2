<?php

namespace App\Http\Controllers;

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

        // Verificar si todos los checks obligatorios están completados
        $requiredCheckIds = Check::where('checklist_id', $projectChecklist->checklist_id)
            ->where('required', true)
            ->pluck('id')
            ->toArray();

        $checkedRequiredChecks = CheckStatus::where('project_checklist_id', $projectChecklistId)
            ->whereIn('check_id', $requiredCheckIds)
            ->where('checked', true)
            ->count();

        $allRequiredChecked = $checkedRequiredChecks === count($requiredCheckIds);

        // Actualizar el estado del checklist
        $projectChecklist->update(['completed' => $allRequiredChecked]);

        return redirect()->back()->with('success', 'Los cambios se han guardado correctamente.');
    }

}
