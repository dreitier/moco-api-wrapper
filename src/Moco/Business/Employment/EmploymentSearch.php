<?php
declare(strict_types=1);

namespace Dreitier\Moco\Business\Employment;

use Carbon\Carbon;
use Dreitier\Moco\Business\User\Model\UserId;
use Dreitier\Moco\Http\ConvertToParameter;
use Dreitier\Moco\Moco;

class EmploymentSearch implements ConvertToParameter
{
    private $from = null;
    private $to = null;
    private UserId|null $user_id = null;

    public function from(Carbon $from): EmploymentSearch
    {
        $this->from = Moco::toDateString($from);
        return $this;
    }

    public function to(Carbon $to): EmploymentSearch
    {
        $this->to = Moco::toDateString($to);
        return $this;
    }

    public function user(UserId|int $userId): EmploymentSearch
    {
        $this->user_id = is_int($userId) ? new UserId($userId) : $userId;
        return $this;
    }

    public static function create(): EmploymentSearch
    {
        return new EmploymentSearch();
    }

    public function toArgs(): array
    {
        $r = [];

        $r += $this->from ? ['from' => $this->from] : [];
        $r += $this->to ? ['to' => $this->to] : [];
        $r += $this->user_id ? ['user_id' => $this->user_id->value] : [];

        return $r;
    }
}
