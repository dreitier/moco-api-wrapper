<?php
declare(strict_types=1);

namespace Dreitier\Moco\Business\Purchase\Model;

use Dreitier\Moco\Business\MocoId;

class CategoryId extends MocoId
{
    public function __construct(public readonly int $value)
    {
    }
}
