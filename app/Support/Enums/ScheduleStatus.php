<?php

declare(strict_types=1);

namespace App\Support\Enums;

use App\Support\ArrayableEnum;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum ScheduleStatus: int implements HasColor, HasLabel
{
    use ArrayableEnum;

    case Draft = 0;

    case Scheduled = 1;

    case Started = 2;

    case Finished = 3;

    public function getColor(): string
    {
        return match ($this) {
            self::Draft => 'gray',
            self::Scheduled => 'info',
            self::Started => 'success',
            self::Finished => 'warning',
        };
    }

    public function getLabel(): string
    {
        return trans('event.schedule_status.'.str($this->name)->slug());
    }

    public function isDraft(): bool
    {
        return $this === self::Draft;
    }

    public function isScheduled(): bool
    {
        return $this === self::Scheduled;
    }

    public function isStarted(): bool
    {
        return $this === self::Started;
    }

    public function isFinished(): bool
    {
        return $this === self::Finished;
    }
}
