<?php

namespace Dreitier\Moco;

use Carbon\Carbon;
use Dreitier\Moco\Http\ClientFactory;
use Dreitier\Moco\Business\Absence\AbsenceService;
use Dreitier\Moco\Business\Activity\ActivityService;
use Dreitier\Moco\Business\Employment\EmploymentService;
use Dreitier\Moco\Business\Invoice\InvoiceService;
use Dreitier\Moco\Business\Presence\PresenceService;
use Dreitier\Moco\Business\Project\ProjectService;
use Dreitier\Moco\Business\Purchase\PurchaseService;
use Dreitier\Moco\Business\Receipt\ReceiptService;
use Dreitier\Moco\Business\User\UserService;
use Dreitier\Moco\Http\Exception;
use function Dreitier\Mocoo\guard_with;

class Moco
{
    private ?ClientFactory $clientFactory = null;

    private $services = [];

    private $mappings = [
        'presences' => [PresenceService::class, '/users/presences'],
        'employments' => [EmploymentService::class, '/users/employments'],
        'activities' => [ActivityService::class, '/activities'],
        'absences' => [AbsenceService::class, '/schedules'],
        'invoices' => [InvoiceService::class, '/invoices'],
        'purchases' => [PurchaseService::class, '/purchases'],
        'receipts' => [ReceiptService::class, '/receipts'],
        'projects' => [ProjectService::class, '/projects'],
        'tasks' => [ProjectService::class, '/projects'],
        'users' => [UserService::class, '/users'],
    ];

    public function __construct(?ClientFactory $clientFactory = null)
    {
        if (!$clientFactory) {
            $clientFactory = new ClientFactory();
        }

        $this->clientFactory = $clientFactory;
    }

    public function __get($property)
    {
        return $this->lookup($property);
    }

    public function __call($method, $args): mixed
    {
        return $this->lookup($method);
    }

    private function lookup(string $name): object
    {
        if (!isset($this->services[$name])) {
            if (!isset($this->mappings[$name])) {
                throw new Exception("services $name does not exist");
            }

            $clazz = $this->mappings[$name][0];
            $endpoint = $this->mappings[$name][1];

            $this->services[$name] = new $clazz($this->clientFactory->create($endpoint));
        }

        return $this->services[$name];
    }


    const DATE_FORMAT = 'Y-m-d';

    public static function toDateString(Carbon $carbon): string
    {
        return $carbon->format(self::DATE_FORMAT);
    }
}
