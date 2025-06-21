<?php

declare(strict_types=1);

use App\Filament\Resources\People\Pages\EditPerson;
use App\Filament\Resources\People\Pages\ListPeople;
use App\Filament\Resources\People\Pages\ViewPerson;
use App\Models\Person;
use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Livewire\livewire;

beforeEach(function () {
    actingAs(User::factory()->asAdmin()->createOne());
});

it('can render the list page', function () {
    $records = Person::factory(count: 5)->createMany();
    $page = livewire(ListPeople::class)->assertOk();

    $page->assertCanSeeTableRecords($records);
});

it('can render the view page', function () {
    $record = Person::factory()->createOne();

    $page = livewire(ViewPerson::class, [
        'record' => $record->getRouteKey(),
    ])->assertOk();
});

it('can render the edit page', function () {
    $record = Person::factory()->createOne();

    $page = livewire(EditPerson::class, [
        'record' => $record->getRouteKey(),
    ])->assertOk();
});
