<?php
declare(strict_types=1);

namespace Dreitier\Moco\Business\User\Model;

use Carbon\Carbon;

class PerformanceReport
{
    private function __construct(public readonly object $data)
    {
    }

    public static function unwrap(object $data)
    {
        return new PerformanceReport($data);
    }

    public function findMonthlyReport(Carbon $date): ?object
    {
        foreach ($this->data->monthly as $monthlyReport) {
            if ($monthlyReport->month == $date->month && $monthlyReport->year == $date->year) {
                return $monthlyReport;
            }
        }

        return null;
    }
}
