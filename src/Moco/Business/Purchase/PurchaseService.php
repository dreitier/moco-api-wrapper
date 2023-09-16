<?php
declare(strict_types=1);

namespace Dreitier\Moco\Business\Purchase;

use Dreitier\Moco\Business\Purchase\Model\Purchases;
use Dreitier\Moco\Http\Client;

class PurchaseService
{
    public function __construct(public readonly Client $client)
    {
    }

    public function findAll(?PurchaseSearch $search = null)
    {
        return Purchases::unwrap($this->client->get_all_pages('', $search));
    }
}
