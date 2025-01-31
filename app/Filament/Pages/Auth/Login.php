<?php

namespace App\Filament\Pages\Auth;

use Filament\Facades\Filament;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Http\Responses\Auth\Contracts\LoginResponse;
use Filament\Pages\Auth\Login as BaseLogin;
use Illuminate\Validation\ValidationException;

class Login extends BaseLogin
{
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('email')
                    ->label(__('Email'))
                    ->email()
                    ->required()
                    ->autofocus(),

                TextInput::make('password')
                    ->label(__('Password'))
                    ->password()
                    ->required(),

                Checkbox::make('remember')
                    ->label(__('Remember Me')),
            ])
            ->statePath('data');
    }

    public function authenticate(): ?LoginResponse
    {
        $data = $this->form->getState();

        if (!Filament::auth()->attempt(
            $this->getCredentialsFromFormData($data), 
            $data['remember'] ?? false // Enables "Remember Me"
        )) {
            throw ValidationException::withMessages([
                'data.email' => __('Invalid login credentials.'),
            ]);
        }

        session()->regenerate();

        return app(LoginResponse::class);
    }
}
