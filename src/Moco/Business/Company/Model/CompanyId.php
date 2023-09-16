<?php
declare(strict_types=1);

namespace Dreitier\Moco\Business\Company\Model;

use Dreitier\Moco\Business\MocoId;

class CompanyId extends MocoId
{
    public function __construct(public readonly int $value)
    {
    }
}
