<?php

declare(strict_types=1);

use App\Filament\Pages\Profile;
use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Livewire\livewire;

it('can render the page', function () {
    actingAs(User::factory()->asSuperAdmin()->createOne());

    livewire(Profile::class)->assertOk();
});
