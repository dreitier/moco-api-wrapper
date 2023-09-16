<?php
declare(strict_types=1);

namespace Dreitier\Moco\Business\Contract\Model;

use Dreitier\Moco\Business\User\Model\UserId;

class ContractExcerpt
{
    public function __construct(
        public readonly UserId $userId,
        public readonly bool   $active,
    )
    {
    }

    public static function unwrap(object $o): ContractExcerpt
    {
        return new ContractExcerpt(
            userId: new UserId($o->user_id),
            active: $o->active,
        );
    }
}
