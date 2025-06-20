<?php

declare(strict_types=1);

namespace App\Models\Builders;

use App\Support\Enums\Gender;
use Illuminate\Database\Eloquent\Builder;

class PersonBuilder extends Builder
{
    public function onlyMales()
    {
        return $this->where('gender', Gender::Male);
    }

    public function onlyFemales()
    {
        return $this->where('gender', Gender::Female);
    }
}
