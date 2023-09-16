<?php
declare(strict_types=1);

namespace Dreitier\Moco\Business\Task\Model;

use Dreitier\Moco\Business\MocoId;

class TaskId extends MocoId
{
    public function __construct(public readonly int $value)
    {
    }
}
