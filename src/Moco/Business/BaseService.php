<?php
declare(strict_types=1);

namespace Dreitier\Moco\Business;

use Dreitier\Moco\Http\BatchResult;
use Dreitier\Moco\Http\Client;

class BaseService
{
    public function __construct(public readonly Client $client)
    {
    }

    /**
     * Deletes one or multiple entities
     *
     * @return void
     */
    public function delete(array $ids = []): BatchResult
    {
        $r = new BatchResult();

        foreach ($ids as $id) {
            try {
                $r->ok($this->client->delete('/' . $id));
            } catch (\Exception $e) {
                $r->fail($id, $e);
            }
        }

        return $r;
    }
}
