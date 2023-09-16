<?php
declare(strict_types=1);

namespace Dreitier\Moco\Business\Presence\Model;

use Carbon\Carbon;
use Dreitier\Moco\Business\Timestamps;
use Dreitier\Moco\Business\User\Model\UserExcerpt;

class Presence
{
    public function __construct(
        public readonly PresenceId  $id,
        public readonly Carbon      $date,
        public readonly Carbon      $from,
        public readonly string      $_from,
        public readonly ?Carbon     $to,
        public readonly ?string     $_to,
        public readonly bool        $isHomeOffice,
        public readonly UserExcerpt $user,
        public readonly Timestamps  $timestamps,
    )
    {

    }

    public function duration(): ?int
    {
        if ($this->to) {
            return abs($this->from->diffInSeconds($this->to));
        }

        return null;
    }

    public static function unwrap($data)
    {
        return new Presence(
            id: new PresenceId($data->id),
            date: Carbon::parse($data->date),
            from: Carbon::parse($data->date . " " . $data->from),
            _from: $data->from,
            to: $data->to ? Carbon::parse($data->date . " " . $data->to) : null,
            _to: $data->to,
            isHomeOffice: $data->is_home_office,
            user: UserExcerpt::unwrap($data->user),
            timestamps: Timestamps::unwrap($data),
        );
    }
}
