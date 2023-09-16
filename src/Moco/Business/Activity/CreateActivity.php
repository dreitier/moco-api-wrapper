<?php
declare(strict_types=1);

namespace Dreitier\Moco\Business\Activity;

use Carbon\Carbon;
use Dreitier\Moco\Business\Project\Model\ProjectId;
use Dreitier\Moco\Business\Task\Model\TaskId;
use Dreitier\Moco\Moco;

class CreateActivity
{
    public function __construct(
        public readonly Carbon    $date,
        public readonly ProjectId $projectId,
        public readonly TaskId    $taskId,
        /* we skip hours due to rounding issues */
        public readonly int       $seconds,
        public readonly ?string   $description = null,
        public readonly ?string   $tag = null,
        public readonly ?string   $remoteService = null,
        public readonly ?string   $remoteId = null,
        public readonly ?string   $remoteUrl = null,
        public readonly ?bool     $billable = null,
    )
    {

    }

    public function wrap(): array
    {
        $r = [
            'date' => Moco::toDateString($this->date),
            'project_id' => $this->projectId->value,
            'task_id' => $this->taskId->value,
            'seconds' => $this->seconds,
            'description' => $this->description,
            'tag' => $this->tag,
            'remote_service' => $this->remoteService,
            'remote_id' => $this->remoteId,
            'remote_url' => $this->remoteUrl,
        ];

        $r += $this->billable !== null ? ['billable' => $this->billable] : [];

        return $r;
    }
}
