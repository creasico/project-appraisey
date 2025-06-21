<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Support\Enums\AthleteLevel;
use Illuminate\Database\Seeder;

class DummySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (AthleteLevel::cases() as $level) {
            $count = value(fn () => fake()->numberBetween(5, 8));

            Event::factory(count: $count)->withParticipants(
                count: fn () => fake()->numberBetween(10, 15),
                level: $level,
            )->withSchedule(
                publishedAt: fn (array $attrs) => fake()->boolean(70) ? $attrs['published_at'] : null,
                startedAt: fn (array $attrs) => $attrs['started_at'],
                finishedAt: fn (array $attrs) => $attrs['finished_at'],
            )->createMany();
        }
    }
}
