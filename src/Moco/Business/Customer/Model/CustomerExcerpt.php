<?php
declare(strict_types=1);

namespace Dreitier\Moco\Business\Customer\Model;

class CustomerExcerpt
{
    public function __construct(
        public readonly CustomerId $id,
        public readonly string     $name,
    )
    {
    }

    public static function unwrap(object $o): CustomerExcerpt
    {
        return new CustomerExcerpt(
            id: new CustomerId($o->id),
            name: $o->name,
        );
    }
}
