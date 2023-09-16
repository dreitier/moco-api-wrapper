<?php
declare(strict_types=1);

namespace Dreitier\Moco\Business\User\Model;

class UserExcerpt
{
    public function __construct(
        public readonly UserId $id,
        public readonly string $firstname,
        public readonly string $lastname,
    )
    {
    }

    public static function unwrap(object $o): UserExcerpt
    {
        return new UserExcerpt(
            id: new UserId($o->id),
            firstname: $o->firstname,
            lastname: $o->lastname,
        );
    }
}
