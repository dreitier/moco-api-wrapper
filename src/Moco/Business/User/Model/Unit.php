<?php
declare(strict_types=1);

namespace Dreitier\Moco\Business\User\Model;

class Unit
{
    public function __construct(
        public readonly UnitId $id,
        public readonly string $name,
    )
    {
    }

    public static function unwrap($data)
    {
        return new Unit(
            id: new UnitId($data->id),
            name: $data->name,
        );
    }
}
