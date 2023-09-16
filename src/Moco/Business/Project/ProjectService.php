<?php
declare(strict_types=1);

namespace Dreitier\Moco\Business\Project;

use Dreitier\Moco\Business\Models;
use Dreitier\Moco\Business\Project\Model\ProjectAssigned;
use Dreitier\Moco\Business\Project\Model\ProjectId;
use Dreitier\Moco\Business\User\Model\UserId;
use Dreitier\Moco\Http\Client;

class ProjectService
{
    public function __construct(public readonly Client $client)
    {
    }

    public function findProjectById(ProjectId $id, bool $includeArchived = false)
    {
        $args = [
            'include_archived' => $includeArchived
        ];

        return $this->client->get('/' . $id, $args);
    }

    public function findAssigned(UserId $id): Models
    {
        $data = $this->client->impersonateNextCall($id)->get('/assigned');

        return Models::of(collect($data)->map(fn($item) => ProjectAssigned::unwrap($item)), ProjectAssigned::class);
    }
}
