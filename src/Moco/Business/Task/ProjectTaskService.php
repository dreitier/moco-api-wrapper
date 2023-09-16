<?php
declare(strict_types=1);

namespace Dreitier\Moco\Business\Task;

use Dreitier\Moco\Http\Client;

class ProjectTaskService
{
    public function __construct(public readonly Client $client)
    {
    }

    public function findTasksInProject(int $projectId)
    {
        return $this->client->get('/' . $projectId . "/tasks");
    }

    public function create(int $projectId, string $name, bool $billable = true, bool $active = true, int $budget = NULL, int $hourlyRate = NULL)
    {
        $args = [
            'name' => $name,
            'billable' => $billable,
            'active' => $active,
            'budget' => $budget,
        ];

        if ($hourlyRate) {
            $args['hourly_rate'] = $hourlyRate;
        }

        return $this->client->post('/' . $projectId . "/tasks", $args);
    }
}
