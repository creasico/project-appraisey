<?php

declare(strict_types=1);

use App\Models\Event;
use App\Models\Participation;
use App\Models\Person;

it('belongs to many participants', function () {
    $model = Event::factory()
        ->withParticipants()
        ->createOne();

    expect($model->participants)->toHaveCount(1);

    $participant = $model->participants->first();

    expect($participant)->toBeInstanceOf(Person::class);
    expect($participant->participation)->toBeInstanceOf(Participation::class);
});
