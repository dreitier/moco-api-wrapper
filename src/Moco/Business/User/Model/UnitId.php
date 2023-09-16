<?php
declare(strict_types=1);

namespace Dreitier\Moco\Business\User\Model;

use Dreitier\Moco\Business\MocoId;

class UnitId extends MocoId
{
    public function __construct(public readonly int $value)
    {
    }
}
