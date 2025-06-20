<?php

namespace App\Models;

use App\Support\Enums\AthleteLevel;
use App\Support\Enums\Gender;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Person extends Model
{
    /** @use HasFactory<\Database\Factories\PersonFactory> */
    use HasFactory, HasUlids;

    protected static string $builder = Builders\PersonBuilder::class;

    protected function casts()
    {
        return [
            'gender' => Gender::class,
            'level' => AthleteLevel::class,
        ];
    }

    /**
     * @return BelongsTo<User, Person>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsToMany<Event, Person, Participation, 'participation'>
     */
    public function participations(): BelongsToMany
    {
        return $this->belongsToMany(Event::class, Participation::class, foreignPivotKey: 'participant_id')
            ->withPivot(['level'])
            ->as('participation');
    }
}
