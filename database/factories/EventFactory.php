<?php

namespace Database\Factories;

use App\Models\Person;
use App\Support\Enums\AthleteLevel;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => (string) str(fake()->words(asText: true))->title(),
            'description' => (string) str(fake()->words(10, true))->ucfirst(),
            'attrs' => null,
            'started_at' => fake()->dateTimeThisMonth(),
            'finished_at' => fn (array $attrs) => $attrs['started_at']
                ? fake()->dateTimeInInterval($attrs['started_at'], '+1 week')
                : null,
            'published_at' => fn (array $attrs) => $attrs['started_at']
                ? fake()->dateTimeInInterval($attrs['started_at'], '-1 week')
                : null,
        ];
    }

    /**
     * @param  (\Closure(): int)|int|null  $count
     * @param  (\Closure(array, \App\Models\Event): array<string, mixed>)|array<string, mixed>|null  $state
     */
    public function withParticipants(
        \Closure|int|null $count = null,
        AthleteLevel $level = AthleteLevel::KhususI,
        \Closure|array|null $state = null,
    ): static {
        return $this->hasAttached(
            Person::factory(count: value($count))->withLevel($level)->state($state),
            [
                'number' => fake()->numerify('###'),
                'level' => $level,
            ],
            'participants'
        );
    }

    public function withSchedule(
        \Closure|\DateTimeInterface|string|null $startedAt = null,
        \Closure|\DateTimeInterface|string|null $finishedAt = null,
        \Closure|\DateTimeInterface|string|null $publishedAt = null,
    ): static {
        return $this->state(fn (array $attrs) => [
            'started_at' => is_string($startedAt) ? Carbon::parse($startedAt) : value($startedAt, $attrs),
            'finished_at' => is_string($finishedAt) ? Carbon::parse($finishedAt) : value($finishedAt, $attrs),
            'published_at' => is_string($publishedAt) ? Carbon::parse($publishedAt) : value($publishedAt, $attrs),
        ]);
    }
}
