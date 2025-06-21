<?php

declare(strict_types=1);

namespace App\Support\Enums;

use App\Support\ArrayableEnum;
use Filament\Support\Contracts\HasLabel;

enum UserRole: int implements HasLabel
{
    use ArrayableEnum;

    case Basic = 0;

    case Admin = 1;

    case SuperAdmin = 2;

    public function getLabel(): string
    {
        return trans('user.role.'.str($this->name)->slug());
    }

    public function isBasic()
    {
        return $this === self::Basic;
    }

    public function isAdmin(): bool
    {
        return $this === self::Admin;
    }

    public function isSuperAdmin(): bool
    {
        return $this === self::SuperAdmin;
    }
}
