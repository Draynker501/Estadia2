<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Pages\ViewRecord;
class ViewUser extends ViewRecord
{
    protected static string $resource = UserResource::class;

    // Customize the fields shown in the modal
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Name')
                    ->disabled(), // Make the field read-only
                Forms\Components\TextInput::make('email')
                    ->label('Email')
                    ->disabled(), // Make the field read-only
                Forms\Components\TextInput::make('roles')
                    ->label('Role')
                    ->disabled()
                    ->formatStateUsing(
                        fn($state, $record) =>
                        $record->roles->pluck('name')->join(', ')
                    ), // Fetch and display roles as a comma-separated string
            ]);
    }

    // Add a 'Back to Index' button
    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('back_to_index')
                ->label('Volver al índice') // Button text
                ->url(UserResource::getUrl('index')) // Redirect to the index page
                ->icon('heroicon-o-arrow-left') // Optional icon
                ->color('primary'), // Standard button style
        ];
    }
}
