<?php

declare(strict_types=1);

namespace App\Events;

use App\Models\Event;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

abstract class AbstractEventSchedule
{
    use Dispatchable, SerializesModels;

    public function __construct(
        public readonly Event $event
    ) {}
}
