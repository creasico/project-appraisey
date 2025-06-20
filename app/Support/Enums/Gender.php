<?php

declare(strict_types=1);

namespace App\Support\Enums;

use App\Support\ArrayableEnum;
use Filament\Support\Contracts\HasLabel;

enum Gender: string implements HasLabel
{
    use ArrayableEnum;

    case Male = 'male';

    case Female = 'female';

    public function getLabel(): string
    {
        return trans('app.gender.'.$this->value);
    }
}
