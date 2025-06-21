<?php

namespace App\Filament\Resources\People\RelationManagers;

use App\Filament\Resources\Events\Schemas\EventForm;
use App\Filament\Resources\Events\Schemas\EventInfolist;
use App\Filament\Resources\Events\Tables\EventsTable;
use App\Models\Event;
use Filament\Actions\ViewAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class ParticipationsRelationManager extends RelationManager
{
    protected static string $relationship = 'participations';

    public function form(Schema $schema): Schema
    {
        return EventForm::configure($schema);
    }

    public function infolist(Schema $schema): Schema
    {
        return EventInfolist::configure($schema);
    }

    public function table(Table $table): Table
    {
        return EventsTable::configure($table, true)
            ->recordActions([
                ViewAction::make()
                    ->visible(fn (Event $record) => $record->is_finished),
            ]);
    }
}
