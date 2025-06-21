<?php

namespace App\Filament\Resources\People\Tables;

use App\Support\Enums\AthleteLevel;
use App\Support\Enums\Gender;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class PeopleTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label(trans('person.field.name'))
                    ->searchable(),

                TextColumn::make('gender')
                    ->label(trans('person.field.gender'))
                    ->searchable()
                    ->width('10%')
                    ->alignCenter(),

                TextColumn::make('level')
                    ->label(trans('person.field.level'))
                    ->sortable()
                    ->width('12%')
                    ->alignCenter(),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('gender')
                    ->options(Gender::class),

                SelectFilter::make('level')
                    ->options(AthleteLevel::class),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
