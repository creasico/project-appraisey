<?php

declare(strict_types=1);

namespace App\Support\Enums;

use App\Support\ArrayableEnum;
use Filament\Support\Contracts\HasLabel;

enum AthleteLevel: int implements HasLabel
{
    use ArrayableEnum;

    case KombiI = 1;

    case KhususIII = 2;

    case KhususII = 3;

    case KhususI = 4;

    public function getLabel(): string
    {
        return trans('athlete.level.'.str($this->name)->slug());
    }
}
