<?php
declare(strict_types=1);

namespace Dreitier\Moco\Business\Activity\Model;

use Carbon\Carbon;
use Dreitier\Moco\Business\Customer\Model\CustomerExcerpt;
use Dreitier\Moco\Business\Project\Model\ProjectExcerpt;
use Dreitier\Moco\Business\Task\Model\TaskExcerpt;
use Dreitier\Moco\Business\Timestamps;
use Dreitier\Moco\Business\User\Model\UserExcerpt;

class Activity
{
    public function __construct(
        public readonly ActivityId      $id,
        public readonly Carbon          $date,
        public readonly float           $hours,
        public readonly int             $seconds,
        public readonly string          $description,
        public readonly bool            $billed,
        public readonly bool            $billable,
        public readonly string          $tag,
        public readonly ?string         $remoteService,
        public readonly ?string         $remoteId,
        public readonly ?string         $remoteUrl,
        public readonly ProjectExcerpt  $project,
        public readonly TaskExcerpt     $task,
        public readonly CustomerExcerpt $customer,
        public readonly UserExcerpt     $user,
        public readonly float           $hourlyRate,
        public readonly ?Carbon         $timerStartedAt,
        public readonly Timestamps      $timestamps,
    )
    {

    }

    public static function unwrap($data)
    {
        return new Activity(
            id: new ActivityId($data->id),
            date: Carbon::parse($data->date),
            hours: $data->hours,
            seconds: $data->seconds,
            description: $data->description,
            billed: $data->billed,
            billable: $data->billable,
            tag: $data->tag,
            remoteService: $data->remote_service,
            remoteId: $data->remote_id,
            remoteUrl: $data->remote_url,
            project: ProjectExcerpt::unwrap($data->project),
            task: TaskExcerpt::unwrap($data->task),
            customer: CustomerExcerpt::unwrap($data->customer),
            user: UserExcerpt::unwrap($data->user),
            hourlyRate: $data->hourly_rate,
            timerStartedAt: $data->timer_started_at ? Carbon::parse($data->timer_started_at) : null,
            timestamps: Timestamps::unwrap($data),
        );
    }
}
