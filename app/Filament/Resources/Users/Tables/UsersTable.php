<?php

namespace App\Filament\Resources\Users\Tables;

use App\Models\User;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label(trans('filament-panels::auth/pages/edit-profile.form.name.label'))
                    ->searchable(),
                TextColumn::make('email')
                    ->label(trans('filament-panels::auth/pages/edit-profile.form.email.label'))
                    ->searchable(),
                TextColumn::make('role')
                    ->label(trans('user.field.role')),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ActionGroup::make([
                    // ViewAction::make(),
                    EditAction::make(),
                ])->visible(fn (User $record) => $record->isNot(auth()->user())),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
