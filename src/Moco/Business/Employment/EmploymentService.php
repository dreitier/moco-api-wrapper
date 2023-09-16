<?php
declare(strict_types=1);

namespace Dreitier\Moco\Business\Employment;

use Carbon\Carbon;
use Dreitier\Moco\Business\Employment\Model\Employments;
use Dreitier\Moco\Business\User\Model\UserId;
use Dreitier\Moco\Http\Client;

class EmploymentService
{
    public function __construct(public readonly Client $client)
    {
    }

    public function findByUser(UserId $userId, ?Carbon $from = null, ?Carbon $to = null): Employments
    {
        return $this->findAll(
            EmploymentSearch::create()
                ->user($userId)
                ->from($from)
                ->to($to)
        );
    }

    public function findAll(?EmploymentSearch $args = null): Employments
    {
        return Employments::unwrap($this->client->get('', $args));
    }
}
