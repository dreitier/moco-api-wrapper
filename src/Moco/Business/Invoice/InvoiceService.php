<?php
declare(strict_types=1);

namespace Dreitier\Moco\Business\Invoice;

use Dreitier\Moco\Business\Invoice\Model\Invoices;
use Dreitier\Moco\Business\Invoice\Model\InvoiceSearch;
use Dreitier\Moco\Http\Client;

class InvoiceService
{
    public function __construct(public readonly Client $client)
    {
    }

    public function findAll(?InvoiceSearch $search = null)
    {
        return Invoices::unwrap($this->client->get_all_pages('', $search));
    }
}
