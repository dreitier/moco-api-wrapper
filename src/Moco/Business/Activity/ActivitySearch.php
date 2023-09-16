<?php
declare(strict_types=1);

namespace Dreitier\Moco\Business\Activity;

use Carbon\Carbon;
use Dreitier\Moco\Business\Company\Model\CompanyId;
use Dreitier\Moco\Business\Project\Model\ProjectId;
use Dreitier\Moco\Business\Task\Model\TaskId;
use Dreitier\Moco\Business\User\Model\UserId;
use Dreitier\Moco\Http\ConvertToParameter;
use Dreitier\Moco\Moco;

class ActivitySearch implements ConvertToParameter
{
    private $ids = [];
    private $from = null;
    private $to = null;
    private UserId|null $user_id = null;
    private ProjectId|null $project_id = null;
    private TaskId|null $task_id = null;
    private CompanyId|null $company_id = null;

    public function ids($ids = []): ActivitySearch
    {
        $this->ids = $ids;
        return $this;
    }

    public function from(Carbon $from): ActivitySearch
    {
        $this->from = Moco::toDateString($from);
        return $this;
    }

    public function to(Carbon $to): ActivitySearch
    {
        $this->to = Moco::toDateString($to);
        return $this;
    }

    public function user(UserId|int $userId): ActivitySearch
    {
        $this->user_id = is_int($userId) ? new UserId($userId) : $userId;
        return $this;
    }

    public function project(ProjectId|int $projectId): ActivitySearch
    {
        $this->project_id = is_int($projectId) ? new ProjectId($projectId) : $projectId;
        return $this;
    }

    public function task(TaskId|int $taskId): ActivitySearch
    {
        $this->task_id = is_int($taskId) ? new TaskId($taskId) : $taskId;
        return $this;
    }

    public function company(CompanyId|int $companyId): ActivitySearch
    {
        $this->company_id = is_int($companyId) ? new CompanyId($companyId) : $companyId;
        return $this;
    }

    public static function create(): ActivitySearch
    {
        return new ActivitySearch();
    }

    public function toArgs(): array
    {
        $r = [];

        $r += sizeof($this->ids) > 0 ? ['ids' => $this->ids] : [];
        $r += $this->from ? ['from' => $this->from] : [];
        $r += $this->to ? ['to' => $this->to] : [];
        $r += $this->user_id ? ['user_id' => $this->user_id->value] : [];
        $r += $this->project_id ? ['project_id' => $this->project_id->value] : [];
        $r += $this->task_id ? ['task_id' => $this->task_id->value] : [];
        $r += $this->company_id ? ['company_id' => $this->company_id->value] : [];

        return $r;
    }
}
