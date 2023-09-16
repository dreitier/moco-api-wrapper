<?php
declare(strict_types=1);

namespace Dreitier\Moco\Business\Absence;

use Carbon\Carbon;
use Dreitier\Moco\Business\User\Model\UserId;
use Dreitier\Moco\Moco;

class CreateAbsence
{
    public function __construct(
        public readonly Carbon $date,
        public readonly int    $absenceCode,
        public readonly UserId $userId,
        public readonly string $comment,
        public readonly bool   $overwrite = true,
        public readonly ?int   $symbol = null,
        public readonly ?bool  $am = false,
        public readonly ?bool  $pm = false,
    )
    {

    }

    public function wrap(): array
    {
        $r = [
            'date' => Moco::toDateString($this->date),
            'absence_code' => $this->absenceCode,
            'user_id' => $this->userId->value,
            'comment' => $this->comment,
            'overwrite' => $this->overwrite,
        ];

        $r += $this->am !== null ? ['am' => $this->am] : [];
        $r += $this->pm !== null ? ['pm' => $this->pm] : [];
        $r += $this->symbol !== null ? ['symbol' => $this->symbol] : [];

        return $r;
    }
}
