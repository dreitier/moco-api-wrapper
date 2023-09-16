<?php
declare(strict_types=1);

namespace Dreitier\Moco\Business\Absence;

use Carbon\Carbon;
use Dreitier\Moco\Business\Absence\Model\Absence;
use Dreitier\Moco\Business\Absence\Model\Absences;
use Dreitier\Moco\Business\User\Model\UserId;
use Dreitier\Moco\Http\Client;

class AbsenceService
{
    public function __construct(public readonly Client $client)
    {
    }

    public function findAll(?AbsenceSearch $search): Absences
    {
        return Absences::unwrap($this->client->get_all_pages('', $search));
    }

    public function findByUser(UserId $userId, ?Carbon $from = null, ?Carbon $until = null, ?int $absenceCode = null): Absences
    {
        $search = AbsenceSearch::create()
            ->user($userId)
            ->from($from ?? Carbon::now())
            ->to($until ?? Carbon::now());

        if ($absenceCode > 0) {
            $search->absenceCode($absenceCode);
        }

        return $this->findAll($search);
    }

    public function upsert(UserId $userId, Carbon $date, int $absenceCode, $comment, ?int $symbol = null): Absence
    {
        return Absence::unwrap($this->client->post('', (new CreateAbsence(
            date: $date,
            absenceCode: $absenceCode,
            userId: $userId,
            comment: $comment,
            overwrite: true,
            symbol: $symbol,
            am: true,
            pm: true,
        ))->wrap()));
    }
}
