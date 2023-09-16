<?php
declare(strict_types=1);

namespace Dreitier\Moco\Business\Purchase\Model;

enum PurchaseStatus: string
{
    case PENDING = 'pending';
    case APPROVED = 'approved';
}
