<?php

namespace Vendor\ClientCrud\Resources\ClientResource\Pages;

use Vendor\ClientCrud\Resources\ClientResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateClient extends CreateRecord
{
    protected static string $resource = ClientResource::class;

    //Redirecciona al index luego de crear un registro
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Cliente creado';
    }
}
