<?php
declare(strict_types=1);

namespace Dreitier\Moco\Business;

class MocoId
{
    public function __construct(public readonly int $value)
    {
    }

    public function __toString(): string
    {
        return "" . $this->value;
    }
}
