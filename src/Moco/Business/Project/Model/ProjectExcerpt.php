<?php
declare(strict_types=1);

namespace Dreitier\Moco\Business\Project\Model;

class ProjectExcerpt
{
    public function __construct(
        public readonly ProjectId $id,
        public readonly string    $name,
        public readonly bool      $billable,
    )
    {
    }

    public static function unwrap(object $o): ProjectExcerpt
    {
        return new ProjectExcerpt(
            id: new ProjectId($o->id),
            name: $o->name,
            billable: $o->billable,
        );
    }
}
