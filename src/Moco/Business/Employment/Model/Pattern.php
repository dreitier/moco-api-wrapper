<?php
declare(strict_types=1);

namespace Dreitier\Moco\Business\Employment\Model;

class Pattern
{
    public function __construct(
        public readonly array $am = [],
        public readonly array $pm = [],
    )
    {
    }

    public static function unwrap(object $o): Pattern
    {
        return new Pattern(
            am: $o->am,
            pm: $o->pm
        );
    }
}
