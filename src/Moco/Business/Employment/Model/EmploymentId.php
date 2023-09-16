<?php
declare(strict_types=1);

namespace Dreitier\Moco\Business\Employment\Model;

use Dreitier\Moco\Business\MocoId;

class EmploymentId extends MocoId
{
    public function __construct(public readonly int $value)
    {
    }
}
