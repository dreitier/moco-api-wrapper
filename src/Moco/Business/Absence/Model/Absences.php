<?php
declare(strict_types=1);

namespace Dreitier\Moco\Business\Absence\Model;

use Dreitier\Moco\Business\Models;

class Absences extends Models
{
    private function __construct(public readonly array $data)
    {
    }

    public static function unwrap(array $data)
    {
        return new Absences(collect($data)->map(fn($item) => Absence::unwrap($item))->toArray());
    }
}
