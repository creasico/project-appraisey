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
            'name' => fn (array $attrs) => implode(' ', [
                fake()->firstName($attrs['gender']),
                fake()->lastName($attrs['gender']),
            ]),
            'gender' => $this->fakeGender(),
            'level' => AthleteLevel::KhususI,
        ];
    }

    /**
     * @param  (\Closure(): int)|int|null  $count
     * @param  (\Closure(array, \App\Models\Person): array<string, mixed>)|array<string, mixed>|null  $state
     */
    public function withParticipations(
        \Closure|int|null $count = null,
        \Closure|array|null $state = null,
    ): static {
        return $this->hasAttached(
            Event::factory(count: value($count))->state($state),
            fn (Person $model) => [
                'number' => fake()->numerify('###'),
                'level' => $model->level,
            ],
            'participations'
        );
    }

    public function withUser(): static
    {
        return $this->for(User::factory(), 'user');
    }
}
