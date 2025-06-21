<?php

namespace App\Filament\Resources\Events\Schemas;

use App\Models\Event;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Flex;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class EventForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Flex::make([
                    Section::make([
                        TextInput::make('title')
                            ->label(trans('event.field.title'))
                            ->autofocus()
                            ->required()
                            ->disabled(fn (Event $record) => $record->is_started),

                        Textarea::make('description')
                            ->label(trans('event.field.description'))
                            ->rows(5)
                            ->disabled(fn (Event $record) => $record->is_started),
                    ])->contained(false),

                    Section::make([
                        TextEntry::make('status')
                            ->badge(),

                        DateTimePicker::make('published_at')
                            ->label(trans('event.field.published_at'))
                            ->seconds(false)
                            ->disabled(fn (Event $record) => $record->is_started),

                        DateTimePicker::make('started_at')
                            ->label(trans('event.field.started_at'))
                            ->seconds(false)
                            ->disabled(fn (Event $record) => $record->is_started),

                        DateTimePicker::make('finished_at')
                            ->label(trans('event.field.finished_at'))
                            ->seconds(false)
                            ->disabled(fn (Event $record) => $record->is_started),
                    ])->contained(false)->grow(false),
                ])->from('md'),
            ]);
    }
}
