<?php

declare(strict_types=1);

use App\Models\Event;
use App\Models\Participation;
use App\Models\Person;
use App\Models\User;

it('belongs to user', function () {
    $model = Person::factory()
        ->withUser()
        ->createOne();

    expect($model->user)->toBeInstanceOf(User::class);
});

it('belongs to many events', function () {
    $model = Person::factory()
        ->withParticipations()
        ->createOne();

    expect($model->participations)->toHaveCount(1);

    $event = $model->participations->first();

    expect($event)->toBeInstanceOf(Event::class);
    expect($event->participation)
        ->toBeInstanceOf(Participation::class);
});
