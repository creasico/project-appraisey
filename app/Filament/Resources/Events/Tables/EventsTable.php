<?php

namespace App\Filament\Resources\Events\Tables;

use App\Models\Event;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ColumnGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\HtmlString;

class EventsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('title')
                    ->label(trans('event.field.title'))
                    ->searchable()
                    ->description(fn (Event $record) => $record->description)
                    ->formatStateUsing(fn (string $state) => new HtmlString("<span class='mr-2'>{$state}</span>"))
                    ->suffix(fn (Event $record) => view('components.badge', [
                        'color' => $record->status->getColor(),
                        'status' => $record->status->getLabel(),
                    ]))
                    ->wrap(),

                TextColumn::make('participant_count')
                    ->label(trans('event.field.participant_count'))
                    ->counts(['participants as participant_count'])
                    ->numeric()
                    ->alignCenter()
                    ->width('10%'),

                ColumnGroup::make(trans('event.schedule_section.label'), [
                    TextColumn::make('started_at')
                        ->label(trans('event.field.started_at'))
                        ->dateTime('M j, Y H:i')
                        ->alignCenter()
                        ->width('12%'),

                    TextColumn::make('finished_at')
                        ->label(trans('event.field.finished_at'))
                        ->dateTime('M j, Y H:i')
                        ->alignCenter()
                        ->width('12%'),
                ]),

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
                //
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
