<?php
declare(strict_types=1);

namespace Dreitier\Moco\Http;

class Exception extends \Exception
{
    public function __construct(string $message, int $code, public readonly Response $moco, public readonly null|array|object $content)
    {
        parent::__construct($message, $code);
    }
}
