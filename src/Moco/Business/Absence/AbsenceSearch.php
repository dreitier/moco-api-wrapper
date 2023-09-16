<?php
declare(strict_types=1);

namespace Dreitier\Moco\Business\Absence;

use Carbon\Carbon;
use Dreitier\Moco\Business\User\Model\UserId;
use Dreitier\Moco\Http\ConvertToParameter;
use Dreitier\Moco\Moco;

class AbsenceSearch implements ConvertToParameter
{
    private $from = null;
    private $to = null;
    private UserId|null $user_id = null;
    private $absenceCode = null;

    public function from(Carbon $from): AbsenceSearch
    {
        $this->from = Moco::toDateString($from);
        return $this;
    }

    public function to(Carbon $to): AbsenceSearch
    {
        $this->to = Moco::toDateString($to);
        return $this;
    }

    public function user(UserId|int $userId): AbsenceSearch
    {
        $this->user_id = is_int($userId) ? new UserId($userId) : $userId;
        return $this;
    }

    public function absenceCode(int $absenceCode): AbsenceSearch
    {
        $this->absenceCode = $absenceCode;
        return $this;
    }

    public static function create(): AbsenceSearch
    {
        return new AbsenceSearch();
    }

    public function toArgs(): array
    {
        $r = [];

        $r += $this->from ? ['from' => $this->from] : [];
        $r += $this->to ? ['to' => $this->to] : [];
        $r += $this->user_id ? ['user_id' => $this->user_id->value] : [];
        $r += $this->absenceCode !== null ? ['absence_code' => $this->absenceCode] : [];

        return $r;
    }
}
