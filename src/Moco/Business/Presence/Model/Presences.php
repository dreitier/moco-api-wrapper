<?php
declare(strict_types=1);

namespace Dreitier\Moco\Business\Presence\Model;

use Dreitier\Moco\Business\Models;

class Presences extends Models
{
    public static function unwrap(array $data)
    {
        return new Presences(collect($data)->map(fn($item) => Presence::unwrap($item))->toArray());
    }
}
