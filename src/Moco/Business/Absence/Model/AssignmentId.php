<?php
declare(strict_types=1);

namespace Dreitier\Moco\Business\Absence\Model;

use Dreitier\Moco\Business\MocoId;

class AssignmentId extends MocoId
{
    public function __construct(public readonly int $value)
    {
    }
}
