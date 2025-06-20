<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                TextInput::make('name')
                    ->label(trans('filament-panels::auth/pages/edit-profile.form.name.label'))
                    ->required(),
                TextInput::make('email')
                    ->label(trans('filament-panels::auth/pages/edit-profile.form.email.label'))
                    ->email()
                    ->required(),
                TextInput::make('password')
                    ->password()
                    ->required(),
            ]);
    }
}
