<?php
declare(strict_types=1);

namespace Dreitier\Moco\Business;

use Carbon\Carbon;

class Timestamps
{
    public function __construct(
        public readonly Carbon $createdAt,
        public readonly Carbon $updatedAt,
    )
    {
    }

    public static function unwrap(object $o): Timestamps
    {
        return new Timestamps(
            createdAt: Carbon::parse($o->created_at),
            updatedAt: Carbon::parse($o->updated_at),
        );
    }
}
