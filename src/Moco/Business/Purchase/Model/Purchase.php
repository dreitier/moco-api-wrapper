<?php
declare(strict_types=1);

namespace Dreitier\Moco\Business\Purchase\Model;

class Purchase
{
    public function __construct(public readonly object $data)
    {
    }

    public function status(): PurchaseStatus
    {
        return PurchaseStatus::from($this->data->status);
    }

    public function payment_method(): PaymentMethod
    {
        return PaymentMethod::from($this->data->payment_method);
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
        return new Purchase($data);
    }
}
