<?php
declare(strict_types=1);

namespace Dreitier\Moco\Business\Presence;

use Dreitier\Moco\Business\BaseService;
use Dreitier\Moco\Business\Presence\Model\Presence;
use Dreitier\Moco\Business\Presence\Model\Presences;
use Dreitier\Moco\Business\User\Model\UserId;

class PresenceService extends BaseService
{
    public function findAll(?PresenceSearch $search = null): Presences
    {
        return Presences::unwrap($this->client->get_all_pages('', $search));
    }

    public function create(UserId $userId, CreatePresence $body): Presence
    {
        return Presence::unwrap($this->client->impersonateNextCall($userId)->post('', $body->wrap()));
    }
}
