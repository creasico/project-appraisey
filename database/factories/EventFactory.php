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
            'attr' => null,
            'started_at' => fake()->dateTimeThisMonth(),
            'finished_at' => fn (array $attrs) => $attrs['started_at']
                ? fake()->dateTimeInInterval($attrs['started_at'], '+1 week')
                : null,
            'published_at' => fn (array $attrs) => $attrs['started_at']
                ? fake()->dateTimeInInterval($attrs['started_at'], '-1 week')
                : null,
        ];
    }

    public function withParticipants(
        \Closure|int|null $count = null,
        AthleteLevel $level = AthleteLevel::KhususI,
    ): static {
        return $this->hasAttached(Person::factory(count: value($count))->withLevel($level), [
            'level' => $level,
        ], 'participants');
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
