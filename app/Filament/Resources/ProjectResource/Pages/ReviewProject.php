<?php

namespace App\Filament\Resources\ProjectResource\Pages;

use App\Filament\Resources\ProjectResource;
use Filament\Resources\Pages\Page;
use Filament\Forms;
use App\Models\ProjectChecklist;
use App\Models\Project;

class ReviewProject extends Page
{
    protected static string $resource = ProjectResource::class;

    protected static string $view = 'filament.resources.project-resource.review-project';

    public Project $record;

    public function mount(Project $record)
    {
        $this->record = $record;
    }

    public function markChecklistAsCompleted($checklistId)
    {
        $checklist = ProjectChecklist::find($checklistId);
        if ($checklist) {
            $checklist->update(['completed' => true]);
        }
    }
}