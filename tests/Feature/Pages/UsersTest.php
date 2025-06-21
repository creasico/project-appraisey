<?php

declare(strict_types=1);

use App\Filament\Resources\Users\Pages\EditUser;
use App\Filament\Resources\Users\Pages\ListUsers;
use App\Filament\Resources\Users\Pages\ViewUser;
use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Livewire\livewire;

it('cannot render the page as admin', function () {
    actingAs(User::factory()->asAdmin()->createOne());

    livewire(ListUsers::class)->assertForbidden();
});

describe('superadmin', function () {
    beforeEach(function () {
        actingAs(User::factory()->asSuperAdmin()->createOne());
    });

    it('can render the list page', function () {
        $records = User::factory(count: 5)->createMany();
        $page = livewire(ListUsers::class)->assertOk();

        $page->assertCanSeeTableRecords($records);
    });

    it('can render the view page', function () {
        $record = User::factory()->createOne();

        $page = livewire(ViewUser::class, [
            'record' => $record->getRouteKey(),
        ])->assertOk();
    });

    it('can render the edit page', function () {
        $record = User::factory()->createOne();

        $page = livewire(EditUser::class, [
            'record' => $record->getRouteKey(),
        ])->assertOk();
    });
});
