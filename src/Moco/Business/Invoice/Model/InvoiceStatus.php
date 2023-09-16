<?php
declare(strict_types=1);

namespace Dreitier\Moco\Business\Invoice\Model;

enum InvoiceStatus: string
{
    case DRAFT = 'draft';
    case CREATED = 'created';
    case SENT = 'sent';
    case PARTIALLY_PAID = 'partially_paid';
    case PAID = 'paid';
    case OVERDUE = 'overdue';
    case IGNORED = 'ignored';
}
