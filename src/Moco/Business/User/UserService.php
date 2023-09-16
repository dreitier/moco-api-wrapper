<?php
declare(strict_types=1);

namespace Dreitier\Moco\Business\User;

use Dreitier\Moco\Business\User\Model\PerformanceReport;
use Dreitier\Moco\Business\User\Model\UserId;
use Dreitier\Moco\Business\User\Model\Users;
use Dreitier\Moco\Http\Client;

class UserService
{
    public function __construct(public readonly Client $client)
    {
    }

    public function findAll($args = ['include_archived' => false]): Users
    {
        return Users::unwrap($this->client->get('', $args));
    }

    public function findPerformanceReport(UserId $userId): PerformanceReport
    {
        return PerformanceReport::unwrap($this->client->get('/' . $userId->value . '/performance_report'));
    }
}
