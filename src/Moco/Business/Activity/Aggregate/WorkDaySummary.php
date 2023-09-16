<?php
declare(strict_types=1);

namespace Dreitier\Moco\Business\Activity\Aggregate;

use Carbon\Carbon;
use Dreitier\Moco\Business\Activity\ActivitySearch;
use Dreitier\Moco\Business\Activity\Model\Activities;
use Dreitier\Moco\Business\Presence\Model\Presences;
use Dreitier\Moco\Business\Presence\PresenceSearch;
use Dreitier\Moco\Business\User\Model\UserId;
use Dreitier\Moco\Moco;
use Dreitier\Temporal\Second;

class WorkDaySummary
{
    public function __construct(
        public readonly Carbon     $date,
        public readonly Activities $activities,
        public readonly Presences  $presences)
    {
    }

    public function totalActivitiesInSeconds(): Second
    {
        $r = 0;

        foreach ($this->activities->data as $activity) {
            $r += $activity->seconds;
        }

        return Second::of($r);
    }

    public function totalPresencesInSeconds(): Second
    {
        $r = 0;

        foreach ($this->presences->data as $presence) {
            $r += $presence->duration() ?? 0;
        }

        return Second::of($r);
    }

    public function activitiesAndPresencesAlign(): bool
    {
        return $this->totalActivitiesInSeconds()->equals($this->totalPresencesInSeconds());
    }

    public static function of(UserId $userId, Carbon $day, ?Activities $activities = null): WorkDaySummary
    {
        // TODO Facade
        $moco = new Moco();

        $presences = $moco->presences()->findAll(
            PresenceSearch::create()->from($day)->to($day)->user($userId)
        );

        if ($activities == null) {
            // ensure that we find all elements on that day in case of overlapping days
            $activities = $moco->activities()->findAll(
                ActivitySearch::create()->from($day)->to($day)->user($userId)
            );
        }

        $r = new WorkDaySummary($day, $activities, $presences);
        return $r;
    }
}
