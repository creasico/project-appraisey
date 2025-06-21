<?php

namespace Database\Factories\Helpers;

use App\Support\Enums\Gender;

trait WithGender
{
    private static ?Gender $gender;

    private function fakeGender()
    {
        return fake()->randomElement(Gender::cases());
    }

    public function withGender(Gender $gender): static
    {
        return $this->state([
            'gender' => $gender,
        ]);
    }
}
