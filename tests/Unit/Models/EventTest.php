<?php

declare(strict_types=1);

use App\Events\EventFinished;
use App\Events\EventPublished;
use App\Events\EventStarted;
use App\Models\Event as EventModel;
use App\Models\Participation;
use App\Models\Person;
use Illuminate\Support\Facades\Event;

it('belongs to many participants', function () {
    $model = EventModel::factory()
        ->withParticipants()
        ->createOne();

    expect($model->participants)->toHaveCount(1);

    $participant = $model->participants->first();

    expect($participant)->toBeInstanceOf(Person::class);
    expect($participant->participation)->toBeInstanceOf(Participation::class);
});

describe('schedules', function () {
    it('should able to be published', function () {
        Event::fake(EventPublished::class);

        $model = EventModel::factory()
            ->withSchedule(publishedAt: null)
            ->createOne();

        expect($model)
            ->is_draft->toBeTrue()
            ->status->isDraft()->toBeTrue();

        $model->markAsPublished();

        expect($model->fresh())->is_draft->toBeFalse();

        Event::assertDispatched(EventPublished::class, 1);
    });

    it('should able to be started', function () {
        Event::fake(EventStarted::class);

        $model = EventModel::factory()
            ->withSchedule(startedAt: null)
            ->createOne();

        expect($model)
            ->is_started->toBeFalse()
            ->is_scheduled->toBeFalse();

        $model->markAsStarted(now()->addDay());

        expect($model = $model->fresh())
            ->is_started->toBeFalse()
            ->is_scheduled->toBeTrue()
            ->status->isScheduled()->toBeTrue();

        $model->markAsStarted();

        expect($model->fresh())
            ->is_started->toBeTrue()
            ->is_scheduled->toBeFalse();

        Event::assertDispatched(EventStarted::class, 1);
    });

    it('should able to be finished', function () {
        Event::fake(EventFinished::class);

        $model = EventModel::factory()
            ->withSchedule(startedAt: now()->subDay(), finishedAt: null)
            ->createOne();

        expect($model)
            ->is_finished->toBeFalse()
            ->is_going->toBeTrue()
            ->status->isStarted()->toBeTrue();

        $model->markAsFinished();

        expect($model->fresh())
            ->is_finished->toBeTrue()
            ->is_going->toBeFalse()
            ->status->isFinished()->toBeTrue();

        Event::assertDispatched(EventFinished::class, 1);
    });
});
