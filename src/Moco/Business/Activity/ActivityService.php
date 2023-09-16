<?php
declare(strict_types=1);

namespace Dreitier\Moco\Business\Activity;

use Dreitier\Moco\Business\Activity\Model\Activities;
use Dreitier\Moco\Business\Activity\Model\Activity;
use Dreitier\Moco\Business\BaseService;

class ActivityService extends BaseService
{
    public function findAll(?ActivitySearch $search = null): Activities
    {
        return Activities::unwrap($this->client->get_all_pages('', $search));
    }

    public function create(CreateActivity $body): Activity
    {
        return Activity::unwrap($this->client->post('', $body->wrap()));
    }
}
