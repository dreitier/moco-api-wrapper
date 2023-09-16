<?php
declare(strict_types=1);

namespace Dreitier\Moco\Http;

// TODO Laravel specific

class ClientFactory
{
    public function create(string $relativePath): Client
    {
        return new Client(
            subdomain: config('moco.tenant'),
            apiKey: config('moco.api.key'),
            relativePath: $relativePath,
            domain: config('moco.domain'),
            apiVersion: config('moco.api.version'),
        );
    }
}
