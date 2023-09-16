<?php
declare(strict_types=1);

namespace Dreitier\Moco\Business\Invoice\Model;

class Invoice
{
    public function __construct(public readonly object $data)
    {
    }

    public function status(): InvoiceStatus
    {
        return InvoiceStatus::from($this->data->status);
    }

    public function hasStatus(... $oneOf)
    {
        foreach ($oneOf as $status) {
            if ($this->status == $status) {
                return true;
            }
        }

        return false;
    }

    public function isReversal()
    {
        return $this->reversed || $this->reversal;
    }

    public function __get($fieldName)
    {
        if (method_exists($this, $fieldName)) {
            return $this->$fieldName();
        }

        return $this->data->$fieldName;
    }

    public static function unwrap(object $data)
    {
        return new Invoice($data);
    }
}
