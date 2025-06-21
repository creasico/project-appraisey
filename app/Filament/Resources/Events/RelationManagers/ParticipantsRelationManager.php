<?php

namespace App\Filament\Resources\Events\RelationManagers;

use App\Filament\Resources\People\Schemas\PersonForm;
use App\Filament\Resources\People\Tables\PeopleTable;
use App\Models\Event;
use Filament\Actions\ActionGroup;
use Filament\Actions\AttachAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DetachAction;
use Filament\Actions\DetachBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

/**
 * @property-read Event $ownerRecord
 */
class ParticipantsRelationManager extends RelationManager
{
    protected static string $relationship = 'participants';

    public function form(Schema $schema): Schema
    {
        return PersonForm::configure($schema);
    }

    public function table(Table $table): Table
    {
        return PeopleTable::configure($table)
            ->headerActions([
                CreateAction::make()
                    ->hidden(fn () => $this->ownerRecord->is_started),

                AttachAction::make()
                    ->hidden(fn () => $this->ownerRecord->is_started),
            ])
            ->recordActions([
                DetachAction::make()
                    ->hidden(fn () => $this->ownerRecord->is_started),

                ViewAction::make()
                    ->visible(fn () => $this->ownerRecord->is_started),

                ActionGroup::make([
                    EditAction::make(),
                    DeleteAction::make(),
                ]),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DetachBulkAction::make(),
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
