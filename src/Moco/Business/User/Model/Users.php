<?php
declare(strict_types=1);

namespace Dreitier\Moco\Business\User\Model;

use Dreitier\Moco\Business\Models;

class Users extends Models
{
    private function __construct(public readonly array $data)
    {
    }

    public static function unwrap(array $data)
    {
        return new Users(collect($data)->map(fn($item) => User::unwrap($item))->toArray());
    }
}
