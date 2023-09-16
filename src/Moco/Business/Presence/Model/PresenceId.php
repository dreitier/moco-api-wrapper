<?php
declare(strict_types=1);

namespace Dreitier\Moco\Business\Presence\Model;

use Dreitier\Moco\Business\MocoId;

class PresenceId extends MocoId
{
    public function __construct(public readonly int $value)
    {
    }
}
