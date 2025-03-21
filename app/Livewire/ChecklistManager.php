<?php

namespace App\Livewire;

use Barryvdh\DomPDF\Facade\pdf as PDF;
use Illuminate\Support\Facades\Mail;
use App\Mail\ProjectChecklistMail;
use Livewire\Component;
use App\Models\ProjectProjectChecklist;
use App\Models\ProjectChecklistCheck;
use App\Models\ProjectCheck;
use App\Models\Project;
use Filament\Notifications\Notification;

class ChecklistManager extends Component
{
    public $record;
    public $checklists = [];

    protected $listeners = ['refreshChecklist' => '$refresh'];

    public function mount($record)
    {
        $this->record = $record;
        $this->loadChecklists();
    }

    public function loadChecklists()
    {
        $this->checklists = $this->record->projectProjectChecklists->map(function ($rel) {
            return [
                'id' => $rel->id,
                'task' => $rel->projectChecklist->task,
                'completed' => $rel->completed,
                'checks' => $rel->projectChecklist->projectChecks->map(function ($check) use ($rel) {
                    return [
                        'id' => $check->id,
                        'name' => $check->name,
                        'required' => $check->required,
                        'checked' => $check->projectChecklistChecks
                            ->where('project_project_checklist_id', $rel->id)
                            ->first()?->checked ?? false
                    ];
                }),
            ];
        });
    }

    public function toggleCheck($relId, $checkId, $checked)
    {
        ProjectChecklistCheck::updateOrCreate(
            [
                'project_project_checklist_id' => $relId,
                'project_check_id' => $checkId
            ],
            [
                'checked' => $checked // Usamos directamente el valor recibido
            ]
        );

        // Revisar si el checklist ya está completo
        $this->updateChecklistStatus($relId);
        $this->loadChecklists();
    }

    private function updateChecklistStatus($relId)
    {
        $rel = ProjectProjectChecklist::findOrFail($relId);

        // Obtener todos los checks asociados al checklist
        $allCheckIds = ProjectCheck::where('project_checklist_id', $rel->project_checklist_id)
            ->pluck('id')
            ->toArray();

        // Obtener solo los checks requeridos
        $requiredCheckIds = ProjectCheck::where('project_checklist_id', $rel->project_checklist_id)
            ->where('required', true)
            ->pluck('id')
            ->toArray();

        // Contar checks completados (tanto requeridos como todos)
        $checkedAll = ProjectChecklistCheck::where('project_project_checklist_id', $relId)
            ->whereIn('project_check_id', $allCheckIds)
            ->where('checked', true)
            ->count();

        $checkedRequired = ProjectChecklistCheck::where('project_project_checklist_id', $relId)
            ->whereIn('project_check_id', $requiredCheckIds)
            ->where('checked', true)
            ->count();

        // Verificar condiciones: todos los requeridos completados o todos los checks completados
        $allChecksCompleted = count($allCheckIds) > 0 && $checkedAll === count($allCheckIds);
        $requiredChecksCompleted = count($requiredCheckIds) > 0 && $checkedRequired === count($requiredCheckIds);

        // Actualizar el estado del checklist
        $rel->update(['completed' => $allChecksCompleted || $requiredChecksCompleted]);
    }

    public function reopenProject()
    {
        $this->record->update(['status' => 0]);
        session()->flash('message', 'El proyecto ha sido reabierto.');

        // Notificación de éxito al reabrir el proyecto
        Notification::make()
            ->title('Proyecto Reabierto')
            ->success()
            ->send();

        $this->loadChecklists();
    }

    public function finalizeProject()
    {
        if ($this->allChecklistsCompleted()) {
            $this->record->update(['status' => 1]);
            session()->flash('message', 'El proyecto ha sido finalizado.');

            // Notificación de éxito al finalizar el proyecto
            Notification::make()
                ->title('Proyecto Finalizado')
                ->success()
                ->send();

            $this->loadChecklists();
        }
    }

    private function allChecklistsCompleted()
    {
        return $this->record->projectProjectChecklists->every(fn($checklist) => $checklist->completed);
    }

    public function render()
    {
        return view('livewire.checklist-manager');
    }

    public function exportPDF()
    {
        $data = [
            'record' => $this->record,
            'checklists' => $this->checklists
        ];

        $pdf = PDF::loadView('pdf.project_checklist', $data);

        // Crear el nombre del archivo basado en el nombre del proyecto
        $fileName = 'Checklist_' . str_replace(' ', '_', $this->record->name) . '.pdf';

        // Mostrar la notificación después de la descarga
        Notification::make()
            ->title('PDF Exportado con Éxito')
            ->success()
            ->send();

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, $fileName);
    }


    public function sendEmail($id)
    {
        $record = Project::with('projectProjectChecklists.projectChecklist.projectChecks.projectChecklistChecks')->findOrFail($id);

        $pdf = app('dompdf.wrapper')->loadView('pdf.project_checklist', compact('record'))->output();

        $destinatario = 'cliente@example.com';

        Mail::to($destinatario)->send(new ProjectChecklistMail($record, $pdf));

        // Notificación después de enviar el correo
        Notification::make()
            ->title('Correo Enviado Correctamente')
            ->success()
            ->send();

        session()->flash('message', 'Correo enviado correctamente.');
    }
}
