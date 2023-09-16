<?php
declare(strict_types=1);

namespace Dreitier\Moco\Business;

class MocoPublicIdentifier
{
    public function __construct(public readonly string $value)
    {
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
