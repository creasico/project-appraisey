<?php

declare(strict_types=1);

namespace App\Models\Helpers;

use App\Support\Enums\ScheduleStatus;
use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * @mixin \Illuminate\Database\Eloquent\Model
 *
 * @property-read \App\Enums\TimelineStatus $status
 */
trait WithSchedule
{
    public static function bootWithSchedule(): void
    {
        static::saving(function (Model $model) {
            /** @var static $model */
            $dirtyAttributes = $model->getDirty();
            $attributes = [
                'published' => $model->getPublishedAtColumn(),
                'started' => $model->getStartedAtColumn(),
                'finished' => $model->getFinishedAtColumn(),
            ];

            foreach ($attributes as $key => $attribute) {
                if (! isset($dirtyAttributes[$attribute]) || $model->getOriginal($attribute)) {
                    continue;
                }

                if ($eventClass = $model->getScheduleEvent($key)) {
                    event(new $eventClass($model));
                }
            }
        });
    }

    public function initializeWithSchedule(): void
    {
        $this->mergeCasts([
            $this->getPublishedAtColumn() => 'datetime',
            $this->getStartedAtColumn() => 'datetime',
            $this->getFinishedAtColumn() => 'datetime',
        ]);
    }

    public function status(): Attribute
    {
        return Attribute::get(function (): ScheduleStatus {
            if ($this->is_finished) {
                return ScheduleStatus::Finished;
            }

            if ($this->is_going) {
                return ScheduleStatus::Started;
            }

            if ($this->is_scheduled) {
                return ScheduleStatus::Scheduled;
            }

            return ScheduleStatus::Draft;
        });
    }

    public function isDraft(): Attribute
    {
        return Attribute::get(
            fn (): bool => $this->{$this->getPublishedAtColumn()} === null
        );
    }

    public function isScheduled(): Attribute
    {
        return Attribute::get(
            fn (): bool => $this->{$this->getStartedAtColumn()}?->gt(now()) ?: false
        );
    }

    public function isGoing(): Attribute
    {
        return Attribute::get(
            fn (): bool => $this->is_started && ! $this->is_finished
        );
    }

    public function isStarted(): Attribute
    {
        return Attribute::get(
            fn (): bool => $this->{$this->getStartedAtColumn()}?->lt(now()) ?: false
        );
    }

    public function isFinished(): Attribute
    {
        return Attribute::get(
            fn (): bool => $this->{$this->getFinishedAtColumn()}?->lt(now()) ?: false
        );
    }

    protected function getPublishedAtColumn(): string
    {
        return $this->scheduleColumns['published'] ?? 'published_at';
    }

    protected function getStartedAtColumn(): string
    {
        return $this->scheduleColumns['started'] ?? 'started_at';
    }

    protected function getFinishedAtColumn(): string
    {
        return $this->scheduleColumns['finished'] ?? 'finished_at';
    }

    /**
     * @return class-string|null
     */
    public function getScheduleEvent(string $key): ?string
    {
        $eventClass = $this->scheduleEvents[$key] ?? 'App\\Events\\'.class_basename($this).Str::title($key);

        return class_exists($eventClass) ? $eventClass : null;
    }

    public function markAsPublished(?CarbonInterface $now = null): bool
    {
        return $this->update([
            $this->getPublishedAtColumn() => $now ?? now(),
        ]);
    }

    public function markAsStarted(?CarbonInterface $now = null): bool
    {
        return $this->update([
            $this->getStartedAtColumn() => $now ?? now(),
        ]);
    }

    public function markAsFinished(?CarbonInterface $now = null): bool
    {
        return $this->update([
            $this->getFinishedAtColumn() => $now ?? now(),
        ]);
    }
}
