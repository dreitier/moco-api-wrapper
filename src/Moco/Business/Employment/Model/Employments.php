<?php
declare(strict_types=1);

namespace Dreitier\Moco\Business\Employment\Model;

use Dreitier\Moco\Business\Models;

class Employments extends Models
{
    public static function unwrap(array $data)
    {
        return new Employments(collect($data)->map(fn($item) => Employment::unwrap($item))->toArray());
    }
}
