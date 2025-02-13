<?php

namespace App\Filament\Resources\ProjectUseResource\Pages;

use App\Filament\Resources\ProjectUseResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProjectUses extends ListRecords
{
    protected static string $resource = ProjectUseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
