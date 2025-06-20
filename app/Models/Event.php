<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Event extends Model
{
    /** @use HasFactory<\Database\Factories\EventFactory> */
    use HasFactory, HasUlids;

    use Helpers\WithSchedule;

    /**
     * @return BelongsToMany<Person, Event, Participation, 'participation'>
     */
    public function participants(): BelongsToMany
    {
        return $this->belongsToMany(Person::class, Participation::class, relatedPivotKey: 'participant_id')
            ->withPivot(['level'])
            ->as('participation');
    }
}
