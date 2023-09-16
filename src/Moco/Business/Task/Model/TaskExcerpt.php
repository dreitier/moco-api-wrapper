<?php
declare(strict_types=1);

namespace Dreitier\Moco\Business\Task\Model;

class TaskExcerpt
{
    public function __construct(
        public readonly TaskId $id,
        public readonly string $name,
        public readonly bool   $billable,
        /*
         * Available for /projects/assigned
         */
        public readonly ?bool  $active = null,
    )
    {
    }

    public static function unwrap(object $o): TaskExcerpt
    {
        return new TaskExcerpt(
            id: new TaskId($o->id),
            name: $o->name,
            billable: $o->billable,
            active: property_exists($o, "active") ? $o->active : null,
        );
    }
}
