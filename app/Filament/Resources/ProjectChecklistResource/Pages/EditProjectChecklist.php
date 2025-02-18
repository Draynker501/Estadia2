<?php

namespace App\Filament\Resources\ProjectChecklistResource\Pages;

use App\Filament\Resources\ProjectChecklistResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProjectChecklist extends EditRecord
{
    protected static string $resource = ProjectChecklistResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
