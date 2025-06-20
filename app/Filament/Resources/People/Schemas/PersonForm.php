<?php

namespace App\Filament\Resources\People\Schemas;

use App\Support\Enums\AthleteLevel;
use App\Support\Enums\Gender;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class PersonForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->relationship('user', 'name'),
                TextInput::make('name')
                    ->required(),
                Select::make('gender')
                    ->options(Gender::class),
                Select::make('level')
                    ->options(AthleteLevel::class)
                    ->required(),
            ]);
    }
}
