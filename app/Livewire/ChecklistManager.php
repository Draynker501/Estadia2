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

        $requiredCheckIds = ProjectCheck::where('project_checklist_id', $rel->project_checklist_id)
            ->where('required', true)
            ->pluck('id')
            ->toArray();

        $checkedRequired = ProjectChecklistCheck::where('project_project_checklist_id', $relId)
            ->whereIn('project_check_id', $requiredCheckIds)
            ->where('checked', true)
            ->count();

        $rel->update(['completed' => $checkedRequired === count($requiredCheckIds)]);
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

        session()->flash('message', 'Correo enviado correctamente.');
    }
}
