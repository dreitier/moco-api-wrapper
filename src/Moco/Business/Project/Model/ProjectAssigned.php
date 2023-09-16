<?php
declare(strict_types=1);

namespace Dreitier\Moco\Business\Project\Model;

use Dreitier\Moco\Business\Contract\Model\ContractExcerpt;
use Dreitier\Moco\Business\Customer\Model\CustomerExcerpt;
use Dreitier\Moco\Business\Models;
use Dreitier\Moco\Business\Task\Model\TaskExcerpt;

class ProjectAssigned
{
    public function __construct(
        public readonly ProjectId         $id,
        public readonly ProjectIdentifier $identifier,
        public readonly string            $name,
        public readonly bool              $active,
        public readonly bool              $billable,
        public readonly CustomerExcerpt   $customer,
        public readonly Models            $tasks,
        public readonly ContractExcerpt   $contract,
    )
    {

    }

    public static function unwrap(object $o)
    {
        return new ProjectAssigned(
            id: new ProjectId($o->id),
            identifier: new ProjectIdentifier($o->identifier),
            name: $o->name,
            active: $o->active,
            billable: $o->billable,
            customer: CustomerExcerpt::unwrap($o->customer),
            tasks: Models::of(collect($o->tasks)->map(fn($item) => TaskExcerpt::unwrap($item)), TaskExcerpt::class),
            contract: ContractExcerpt::unwrap($o->contract)
        );
    }
}
