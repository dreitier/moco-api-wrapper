<?php
declare(strict_types=1);

namespace Dreitier\Moco\Business\Employment\Model;

use Carbon\Carbon;
use Dreitier\Moco\Business\Timestamps;
use Dreitier\Moco\Business\User\Model\UserExcerpt;

class Employment
{
    public function __construct(
        public readonly EmploymentId $id,
        public readonly float        $weeklyTargetHours,
        public readonly Pattern      $pattern,
        public readonly Carbon       $from,
        public readonly ?Carbon      $to,
        public readonly UserExcerpt  $user,
        public readonly Timestamps   $timestamps,
    )
    {

    }

    public static function unwrap($data)
    {
        return new Employment(
            id: new EmploymentId($data->id),
            weeklyTargetHours: $data->weekly_target_hours,
            pattern: Pattern::unwrap($data->pattern),
            from: Carbon::parse($data->from),
            to: $data->to ? Carbon::parse($data->to) : null,
            user: UserExcerpt::unwrap($data->user),
            timestamps: Timestamps::unwrap($data),
        );
    }
}
