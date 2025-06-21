<?php

declare(strict_types=1);

use App\Filament\Resources\Events\Pages\EditEvent;
use App\Filament\Resources\Events\Pages\ListEvents;
use App\Filament\Resources\Events\Pages\ViewEvent;
use App\Models\Event;
use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Livewire\livewire;

beforeEach(function () {
    actingAs(User::factory()->asAdmin()->createOne());
});

it('can render the list page', function () {
    $records = Event::factory(count: 10)->createMany();
    $page = livewire(ListEvents::class)->assertOk();

    $page->assertCanSeeTableRecords($records);
});

it('can render the view page', function () {
    $record = Event::factory()->createOne();

    $page = livewire(ViewEvent::class, [
        'record' => $record->getRouteKey(),
    ])->assertOk();
});

it('can render the edit page', function () {
    $record = Event::factory()->createOne();

    $page = livewire(EditEvent::class, [
        'record' => $record->getRouteKey(),
    ])->assertOk();
});
