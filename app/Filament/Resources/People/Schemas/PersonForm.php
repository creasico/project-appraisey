<?php

namespace App\Filament\Resources\People\Schemas;

use App\Support\Enums\AthleteLevel;
use App\Support\Enums\Gender;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PersonForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('general')
                    ->aside()
                    ->schema([
                        TextInput::make('name')
                            ->label(trans('person.field.name'))
                            ->required(),

                        Radio::make('gender')
                            ->label(trans('person.field.gender'))
                            ->required()
                            ->options(Gender::class)
                            ->columns(2),

                        Radio::make('level')
                            ->label(trans('person.field.level'))
                            ->required()
                            ->options(AthleteLevel::class)
                            ->columns(2),
                    ]),
            ]);
    }
}
