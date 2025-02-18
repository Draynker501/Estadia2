<?php

namespace App\Filament\Resources\ProjectChecklistResource\Pages;

use App\Filament\Resources\ProjectChecklistResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProjectChecklists extends ListRecords
{
    protected static string $resource = ProjectChecklistResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
