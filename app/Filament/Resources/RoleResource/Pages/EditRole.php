<?php

namespace App\Filament\Resources\RoleResource\Pages;

use App\Filament\Resources\RoleResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRole extends EditRecord
{
    protected static string $resource = RoleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    //Redirecciona al index luego de editar un registro
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return 'Rol actualizado';
    }

    // Personaliza la acción de guardar para mostrar un modal de confirmación
    protected function getSaveFormAction(): Actions\Action
    {
        return parent::getSaveFormAction()
            ->submit(form: null)
            ->requiresConfirmation()
            ->action(function () {
                $this->closeActionModal();
                $this->save();
            });
    }
}
