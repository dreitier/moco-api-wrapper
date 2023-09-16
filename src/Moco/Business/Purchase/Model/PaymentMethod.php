<?php
declare(strict_types=1);

namespace Dreitier\Moco\Business\Purchase\Model;

enum PaymentMethod: string
{
    case BANK_TRANSFER = 'bank_transfer';
    case DIRECT_DEBIT = 'direct_debit';
    case CREDIT_CARD = 'credit_card';
    case PAYPAL = 'paypal';
    case CASH = 'cash';
}
