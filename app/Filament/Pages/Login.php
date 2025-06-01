<?php

namespace App\Filament\Pages;

use Filament\Forms\Components\Component;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\HtmlString;
use Illuminate\Validation\ValidationException;

class Login extends \Filament\Pages\Auth\Login
{



    protected function getEmailFormComponent(): Component
    {
        return TextInput::make('username')
            ->label('نام کاربری')
            ->required()
            ->autocomplete()
            ->autofocus()
            ->extraInputAttributes(['tabindex' => 1,'dir' => 'ltr']);
    }
    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function getCredentialsFromFormData(array $data): array
    {
        return [
            'username' => $data['username'],
            'password' => $data['password'],
        ];
    }


    /**
     * @throws ValidationException
     */
    protected function throwFailureValidationException(): never
    {
        throw ValidationException::withMessages([
            'data.username' => __('filament-panels::pages/auth/login.messages.failed'),
        ]);
    }


    protected function getPasswordFormComponent(): Component
    {
        return TextInput::make('password')
            ->label(__('filament-panels::pages/auth/login.form.password.label'))
            ->hint(filament()->hasPasswordReset() ? new HtmlString(Blade::render('<x-filament::link :href="filament()->getRequestPasswordResetUrl()" tabindex="3"> {{ __(\'filament-panels::pages/auth/login.actions.request_password_reset.label\') }}</x-filament::link>')) : null)
            ->password()
            ->revealable(filament()->arePasswordsRevealable())
            ->autocomplete('current-password')
            ->required()
            ->extraInputAttributes(['tabindex' => 2,'dir' => 'ltr']);
    }

}
