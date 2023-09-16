<?php
declare(strict_types=1);

namespace Dreitier\Moco\Business\Absence\Model;

use Carbon\Carbon;
use Dreitier\Moco\Business\Timestamps;
use Dreitier\Moco\Business\User\Model\UserExcerpt;

class Absence
{
    public function __construct(
        public readonly AbsenceId   $id,
        public readonly Carbon      $date,
        public readonly string      $comment,
        public readonly bool        $am,
        public readonly bool        $pm,
        public readonly Assignment  $assignment,
        public readonly UserExcerpt $user,
        public readonly Timestamps  $timestamps,
        public readonly ?int        $symbol = null,
    )
    {

    }

    public static function unwrap($data)
    {
        return new Absence(
            id: new AbsenceId($data->id),
            date: Carbon::parse($data->date),
            comment: $data->comment,
            am: $data->am,
            pm: $data->pm,
            assignment: Assignment::unwrap($data->assignment),
            user: UserExcerpt::unwrap($data->user),
            timestamps: Timestamps::unwrap($data),
            symbol: $data->symbol,
        );
    }
}
