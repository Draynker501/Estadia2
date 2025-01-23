<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewUser extends ViewRecord
{
    protected static string $resource = UserResource::class;

    // Añadimos el botón al encabezado
    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('back_to_index')
                ->label('Volver al índice') // Texto del botón
                ->url(UserResource::getUrl('index')) // Redirige al índice del recurso
                ->icon('heroicon-o-arrow-left') // Ícono opcional
                ->color('primary'), // Mantiene el estilo de botones estándar
        ];
    }
}
