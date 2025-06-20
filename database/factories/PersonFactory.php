<?php

namespace Database\Factories;

use App\Models\Event;
use App\Models\Person;
use App\Models\User;
use App\Support\Enums\AthleteLevel;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Person>
 */
class PersonFactory extends Factory
{
    use Helpers\WithAthleteLevel;
    use Helpers\WithGender;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fn (array $attr) => implode(' ', [
                fake()->firstName($attr['gender'] ?? self::$gender),
                fake()->lastName($attr['gender'] ?? self::$gender),
            ]),
            'gender' => $this->fakeGender(),
            'level' => AthleteLevel::KhususI,
        ];
    }

    public function withParticipations(
        \Closure|int|null $count = null,
    ): static {
        return $this->hasAttached(Event::factory(count: value($count)), fn (Person $model) => [
            'level' => $model->level,
        ], 'participations');
    }

    public function withUser(): static
    {
        return $this->for(User::factory(), 'user');
    }
}
