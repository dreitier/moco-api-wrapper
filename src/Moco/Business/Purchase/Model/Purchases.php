<?php
declare(strict_types=1);

namespace Dreitier\Moco\Business\Purchase\Model;

class Purchases
{
    private function __construct(public readonly array $data)
    {
    }

    public static function unwrap(array $data)
    {
        return new Purchases(collect($data)->map(fn($item) => Purchase::unwrap($item))->toArray());
    }
}
