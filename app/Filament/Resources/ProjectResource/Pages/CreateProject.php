<?php

namespace App\Filament\Resources\ProjectResource\Pages;

use App\Filament\Resources\ProjectResource;
use App\Models\ProjectChecklist;
use App\Models\ProjectChecklistCheck;
use App\Models\ProjectProjectChecklist;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateProject extends CreateRecord
{
    protected static string $resource = ProjectResource::class;

    protected function afterCreate(): void
    {
        $project = $this->record;
        $checklists = $this->data['projectChecklists'] ?? [];

        foreach ($checklists as $checklistData) {
            // Buscar el checklist original
            $originalChecklist = ProjectChecklist::find($checklistData['project_checklist_id']);

            if ($originalChecklist) {
                // Clonamos el checklist original
                $duplicatedChecklist = $originalChecklist->replicate();
                $duplicatedChecklist->is_cloned = true; // Marcamos como clonado
                $duplicatedChecklist->save();

                // Buscar la relación existente o crear una nueva
                $projectProjectChecklist = ProjectProjectChecklist::where('project_id', $project->id)
                    ->where('project_checklist_id', $originalChecklist->id)
                    ->first();

                $projectProjectChecklist->project_checklist_id = $duplicatedChecklist->id;
                $projectProjectChecklist->save();
            }

            // Clonamos las checks del checklist original para asociarlas con el checklist clonado
            foreach ($originalChecklist->projectChecks as $check) {
                $duplicatedCheck = $check->replicate();
                $duplicatedCheck->project_checklist_id = $duplicatedChecklist->id; // Asociamos al checklist clonado
                $duplicatedCheck->save();

                // Crear la relación entre el proyecto y el check clonado
                ProjectChecklistCheck::create([
                    'project_project_checklist_id' => $projectProjectChecklist->id,
                    'project_check_id' => $duplicatedCheck->id,
                    'checked' => false, // Por defecto, todos los checks estarán desmarcados
                ]);
            }
        }
    }
}

