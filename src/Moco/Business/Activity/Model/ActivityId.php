<?php
declare(strict_types=1);

namespace Dreitier\Moco\Business\Activity\Model;

use Dreitier\Moco\Business\MocoId;

class ActivityId extends MocoId
{
    public function __construct(public readonly int $value)
    {
    }
}
