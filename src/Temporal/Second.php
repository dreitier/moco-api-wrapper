<?php
declare(strict_types=1);

namespace Dreitier\Temporal;

use Dreitier\Temporal\Work\IndustryHour;

class Second extends Number
{
    public function toIndustryHour(): IndustryHour
    {
        $hours = floor($this->value / 3600);
        $secondsRest = ($this->value % 3600);

        $totalIndustryHours = (float)$hours + (float)((float)$secondsRest / 3600);

        return IndustryHour::of($totalIndustryHours);
    }

    public function toIndustryHours(): IndustryHour
    {
        return $this->toIndustryHour();
    }

    public function format($separator = ":"): string
    {
        $hours = floor($this->value / 3600);
        $minutesRest = floor($this->value % 3600) / 60;
        $padding = "";

        if ($minutesRest <= 9) {
            $padding = "0";
        }

        return $hours . $separator . $padding . $minutesRest;
    }

    public static function parseHours(string $s): Second
    {
        $seconds = 0;

        if (preg_match('/^(0?(\d{1,2}))(:(\d+))?$/', $s, $matches)) {
            $hours = $matches[2];
            $minutes = sizeof($matches) >= 5 ? $matches[4] : 0;

            $seconds = ($hours * 3600) + ($minutes * 60);
        }

        return Second::of($seconds);
    }

    public static function none(): Second
    {
        return new Second(0);
    }

    public static function ofMinutes(int $minutes): Second
    {
        return new Second($minutes * 60);
    }

    public static function of(int|float $seconds): Second
    {
        return new Second((int)$seconds);
    }

    public function minus(Second $other)
    {
        return new Second($this->value - $other->value);
    }

    public function plus(Second $other)
    {
        return new Second($this->value + $other->value);
    }
}

