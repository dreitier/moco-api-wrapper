<?php
declare(strict_types=1);

namespace Dreitier\Moco\Business\Activity\Model;

use Dreitier\Moco\Business\Project\Model\ProjectId;
use Dreitier\Moco\Business\Task\Model\TaskId;
use Dreitier\Moco\Http\Exception;

class ProjectTaskId
{
    private function __construct(
        public readonly ProjectId $projectId,
        public readonly TaskId    $taskId)
    {
    }

    public static function from(string $serialized)
    {
        $parts = explode(":", $serialized);

        if (sizeof($parts) != 2) {
            throw new Exception("Serialized key '$serialized' does not match expected format");
        }

        return self::of(new ProjectId((int)$parts[0]), new TaskId((int)$parts[1]));
    }

    public static function of(ProjectId $projectId, TaskId $taskId)
    {
        return new static($projectId, $taskId);
    }

    public function serialize(): string
    {
        return '' . $this;
    }

    public function __toString()
    {
        return $this->projectId->value . ":" . $this->taskId->value;
    }
}
