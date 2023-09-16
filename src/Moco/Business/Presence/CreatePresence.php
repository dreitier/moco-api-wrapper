<?php
declare(strict_types=1);

namespace Dreitier\Moco\Business\Presence;

use Carbon\Carbon;
use Dreitier\Moco\Moco;

class CreatePresence
{
    public function __construct(
        public readonly Carbon  $date,
        public readonly Carbon  $begin,
        public readonly bool    $isHomeOffice,
        public readonly ?Carbon $end = null,
    )
    {

    }

    public function wrap(): array
    {
        $r = [
            'date' => Moco::toDateString($this->date),
            'from' => $this->begin->format("H:i"),
            'is_home_office' => $this->isHomeOffice,
        ];

        $r += $this->end ? ['to' => $this->end->format("H:i")] : [];

        return $r;
    }
}
