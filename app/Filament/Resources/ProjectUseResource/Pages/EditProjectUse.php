<?php

namespace App\Filament\Resources\ProjectUseResource\Pages;

use App\Filament\Resources\ProjectUseResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProjectUse extends EditRecord
{
    protected static string $resource = ProjectUseResource::class;

    public function getView(): string
    {
        return 'filament.pages.project-use-checklists';
    }

    protected function getViewData(): array
    {
        return [
            'record' => $this->record,
        ];
    }
}
