<?php

namespace App\Filament\Resources\Events;

use App\Filament\Resources\Events\Pages\CreateEvent;
use App\Filament\Resources\Events\Pages\EditEvent;
use App\Filament\Resources\Events\Pages\ListEvents;
use App\Filament\Resources\Events\Pages\ViewEvent;
use App\Filament\Resources\Events\Schemas\EventForm;
use App\Filament\Resources\Events\Schemas\EventInfolist;
use App\Filament\Resources\Events\Tables\EventsTable;
use App\Models\Event;
use App\View\Navigations\GroupManage;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class EventResource extends Resource
{
    use GroupManage;

    protected static ?string $model = Event::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Schema $schema): Schema
    {
        return EventForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return EventInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return EventsTable::configure($table)
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make()
                    ->hidden(fn (Event $record) => $record->is_finished),

                ViewAction::make()
                    ->visible(fn (Event $record) => $record->is_finished),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\ParticipantsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListEvents::route('/'),
            'create' => CreateEvent::route('/create'),
            'view' => ViewEvent::route('/{record}'),
            'edit' => EditEvent::route('/{record}/edit'),
        ];
    }
}
