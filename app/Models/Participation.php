<?php

namespace App\Models;

use App\Support\Enums\AthleteLevel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class Participation extends Pivot
{
    protected $table = 'participations';

    public $timestamps = false;

    protected function casts()
    {
        return [
            'level' => AthleteLevel::class,
            'attrs' => 'array',
        ];
    }

    /**
     * @return BelongsTo<Person, Participation>
     */
    public function participant(): BelongsTo
    {
        return $this->belongsTo(Person::class, 'participant_id');
    }

    /**
     * @return BelongsTo<Event, Participation>
     */
    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class, 'event_id');
    }
}
