<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use App\Notifications\UserUpdatedNotification;
use App\Notifications\UserDeletedNotification;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

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

    // Envía la notificación después de editar un usuario
    protected function afterSave(): void
    {
        if ($this->record->send_notification) {
            $this->record->notify(new UserUpdatedNotification());
        }
    }

    // Envía la notificación después de eliminar un usuario
    protected function afterDelete(): void
    {
        if ($this->record->send_notification) {
            $this->record->notify(new UserDeletedNotification());
        }
    }

}
