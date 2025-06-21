<?php

namespace Database\Factories\Helpers;

use App\Support\Enums\AthleteLevel;

trait WithAthleteLevel
{
    public function withLevel(AthleteLevel $level): static
    {
        return $this->state([
            'level' => $level,
        ]);
    }
}
