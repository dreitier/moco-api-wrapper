<?php
declare(strict_types=1);

namespace Dreitier\Moco\Business\Absence\Model;

class Assignment
{
    public function __construct(
        public readonly AssignmentId $id,
        public readonly string       $name,
        public readonly string       $customerName,
        public readonly string       $color,
        public readonly string       $type)
    {
    }

    public function absenceCode(): AbsenceCode
    {
        return AbsenceCode::fromNameAndType($this->name, $this->type);
    }

    public static function unwrap($o): Assignment
    {
        return new Assignment(
            id: new AssignmentId($o->id),
            name: $o->name,
            customerName: $o->customer_name,
            color: $o->color,
            type: $o->type
        );
    }
}
