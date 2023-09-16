<?php
declare(strict_types=1);

namespace Dreitier\Temporal\Work;

use Dreitier\Temporal\Number;
use Dreitier\Temporal\Second;

class IndustryHour extends Number
{
    public function toSeconds(): Second
    {
        if (!$this->value) {
            return Second::none();
        }

        $hours = floor($this->value);
        $industryMinutesRest = ($this->value * 100) - ($hours * 100);
        $seconds = $industryMinutesRest / 100 * 3600;

        $totalSeconds = ($hours * 60 * 60) + $seconds;

        return Second::of($totalSeconds);
    }

    public function format($separator = ","): string
    {
        return intval($this->value) . $separator . explode('.', number_format($this->value, 2))[1];
    }

    public static function of(float $industryHours)
    {
        return new IndustryHour($industryHours);
    }

    public static function none(): IndustryHour
    {
        return new IndustryHour(0);
    }

    public function __toString(): string
    {
        return $this->value . "h";
    }
}

