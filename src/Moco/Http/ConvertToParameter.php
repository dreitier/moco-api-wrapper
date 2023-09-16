<?php
declare(strict_types=1);

namespace Dreitier\Moco\Http;

interface ConvertToParameter
{
    public function toArgs(): array;
}
