<?php
declare(strict_types=1);

namespace Dreitier\Moco\Business\Presence;

use Carbon\Carbon;
use Dreitier\Moco\Business\User\Model\UserId;
use Dreitier\Moco\Http\ConvertToParameter;
use Dreitier\Moco\Moco;

class PresenceSearch implements ConvertToParameter
{
    private $from = null;
    private $to = null;
    private $is_home_office = null;
    private UserId|null $user_id = null;

    public function from(Carbon $from): PresenceSearch
    {
        $this->from = Moco::toDateString($from);
        return $this;
    }

    public function to(Carbon $to): PresenceSearch
    {
        $this->to = Moco::toDateString($to);
        return $this;
    }

    public function user(UserId|int $userId): PresenceSearch
    {
        $this->user_id = is_int($userId) ? new UserId($userId) : $userId;
        return $this;
    }

    public function isHomeOffice(bool $isHomeOffice): PresenceSearch
    {
        $this->is_home_office = $isHomeOffice;
        return $this;
    }

    public static function create(): PresenceSearch
    {
        return new PresenceSearch();
    }

    public function toArgs(): array
    {
        $r = [];

        $r += $this->from ? ['from' => $this->from] : [];
        $r += $this->to ? ['to' => $this->to] : [];
        $r += $this->is_home_office !== null ? ['is_home_office' => $this->is_home_office] : [];
        $r += $this->user_id ? ['user_id' => $this->user_id->value] : [];

        return $r;
    }
}
