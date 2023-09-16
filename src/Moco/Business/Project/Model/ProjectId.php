<?php
declare(strict_types=1);

namespace Dreitier\Moco\Business\Project\Model;

use Dreitier\Moco\Business\MocoId;

class ProjectId extends MocoId
{
    public function __construct(public readonly int $value)
    {
    }
}
