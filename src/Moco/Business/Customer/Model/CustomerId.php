<?php
declare(strict_types=1);

namespace Dreitier\Moco\Business\Customer\Model;

use Dreitier\Moco\Business\MocoId;

class CustomerId extends MocoId
{
    public function __construct(public readonly int $value)
    {
    }
}
