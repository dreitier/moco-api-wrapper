<?php
declare(strict_types=1);

namespace Dreitier\Moco\Business\Invoice\Model;

use Dreitier\Moco\Business\Models;

class Invoices extends Models
{
    private function __construct(public readonly array $data)
    {
    }

    public static function unwrap(array $data)
    {
        return new Invoices(collect($data)->map(fn($item) => Invoice::unwrap($item))->toArray());
    }
}
