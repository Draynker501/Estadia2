<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use App\Notifications\WelcomeUserNotification;
use Filament\Resources\Pages\CreateRecord;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class; 

    //Redirecciona al index luego de crear un registro
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    // Envía la notificación después de crear un usuario
    protected function afterCreate(): void
    {
        if ($this->record->send_notification) {
            $this->record->notify(new WelcomeUserNotification());
        }
    }
}
