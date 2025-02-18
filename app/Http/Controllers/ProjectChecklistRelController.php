<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;
use App\Models\ProjectChecklistCheck;
use App\Models\ProjectChecklistRel;
use App\Models\ProjectCheck;
use Illuminate\Support\Facades\Mail;
use App\Mail\ProjectChecklistMail;

class ProjectChecklistRelController extends Controller
{
    public function markCheck(Request $request, $checkId)
    {
        $check = ProjectCheck::findOrFail($checkId);
        $projectChecklistId = $request->input('project_checklist_rel_id');

        // Actualizar o crear el estado del check en ProjectChecklistCheck
        ProjectChecklistCheck::updateOrCreate(
            [
                'project_checklist_rel_id' => $projectChecklistId,
                'project_check_id' => $checkId
            ],
            [
                'checked' => $request->has('checked') // Se marca como true o false dependiendo de si viene en la request
            ]
        );

        // Obtener los IDs de los checks obligatorios para este checklist
        $requiredCheckIds = ProjectCheck::where('project_checklist_id', $check->project_checklist_id)
            ->where('required', true)
            ->pluck('id')
            ->toArray();

        // Contar cuántos de los checks obligatorios están marcados en ProjectChecklistCheck
        $checkedRequiredChecks = ProjectChecklistCheck::where('project_checklist_rel_id', $projectChecklistId)
            ->whereIn('project_check_id', $requiredCheckIds)
            ->where('checked', true)
            ->count();

        // Marcar el checklist como completado solo si todos los obligatorios están marcados
        $allRequiredChecked = $checkedRequiredChecks === count($requiredCheckIds);

        ProjectChecklistRel::where('id', $projectChecklistId)
            ->update(['completed' => $allRequiredChecked]);

        return back();
    }

    public function updateChecks(Request $request, $projectChecklistId)
    {
        $projectChecklist = ProjectChecklistRel::findOrFail($projectChecklistId);

        // Obtener los checks enviados desde el formulario
        $checks = $request->input('checks', []);

        foreach ($checks as $checkId => $value) {
            ProjectChecklistCheck::updateOrCreate(
                [
                    'project_checklist_rel_id' => $projectChecklist->id,
                    'project_check_id' => $checkId
                ],
                [
                    'checked' => (bool) $value // Convertir el valor a booleano
                ]
            );
        }

        // Obtener IDs de checks requeridos y todos los checks en el checklist
        $checklistId = $projectChecklist->project_checklist_id;
        $requiredCheckIds = ProjectCheck::where('project_checklist_id', $checklistId)
            ->where('required', true)
            ->pluck('id')
            ->toArray();

        $allCheckIds = ProjectCheck::where('project_checklist_id', $checklistId)
            ->pluck('id')
            ->toArray();

        // Contar cuántos de estos están marcados en ProjectChecklistCheck
        $checkedRequiredChecks = ProjectChecklistCheck::where('project_checklist_rel_id', $projectChecklistId)
            ->whereIn('project_check_id', $requiredCheckIds)
            ->where('checked', true)
            ->count();

        $checkedAllChecks = ProjectChecklistCheck::where('project_checklist_rel_id', $projectChecklistId)
            ->whereIn('project_check_id', $allCheckIds)
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
        $record = Project::with('projectChecklistRels.projectChecklist.projectChecks.projectChecklistChecks')->findOrFail($id);

        // Reemplazar espacios y caracteres especiales en el nombre del archivo
        $fileName = str_replace([' ', '/'], '-', $record->name) . '.pdf';

        $pdf = app('dompdf.wrapper')->loadView('pdf.project_checklist', compact('record'));

        return $pdf->download($fileName);
    }

    public function enviarPDFPorCorreo($id)
    {
        // Obtener el proyecto con las relaciones necesarias
        $record = Project::with('projectChecklistRels.projectChecklist.projectChecks.projectChecklistChecks')->findOrFail($id);

        // Generar el PDF
        $pdf = app('dompdf.wrapper')->loadView('pdf.project_checklist', compact('record'))->output();

        // Definir el destinatario (puedes modificarlo según tus necesidades)
        $destinatario = 'cliente@example.com'; // Esto puede ser dinámico

        // Enviar el correo con el archivo PDF adjunto
        Mail::to($destinatario)->send(new ProjectChecklistMail($record, $pdf));

        // Retornar una respuesta o redirigir
        return back()->with('success', 'Correo enviado con éxito.');
    }
}
