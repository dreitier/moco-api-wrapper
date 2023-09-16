<?php
declare(strict_types=1);

namespace Dreitier\Moco\Business\Presence\Aggregate;

use Carbon\Carbon;
use Dreitier\Moco\Business\Presence\CreatePresence;
use Dreitier\Temporal\Second;

class WorkDayPresence
{
    public function __construct(
        public readonly Carbon $date,
        public readonly array  $segments,
        public readonly bool   $isHomeOffice = true)
    {
    }

    public function begin(): Carbon
    {
        return $this->segments[0][0];
    }

    public function end(): Carbon
    {
        $idx = 0;

        if (sizeof($this->segments) > 1) {
            $idx = sizeof($this->segments) - 1;
        }

        return $this->segments[$idx][1];
    }

    public function __toString()
    {
        return $this->begin('H:i') . " - " . $this->end('H:i') . ", " . $this->totalPause()->toIndustryHours();
    }

    public function totalPause(): Second
    {
        $seconds = 0;
        $lastEnd = null;

        foreach ($this->segments as $segment) {
            if ($lastEnd != null) {
                $diff = $segment[0]->diffAsCarbonInterval($lastEnd);
                $seconds += $diff->totalSeconds;
            }

            $lastEnd = $segment[1];
        }

        return Second::of($seconds);
    }

    public function totalWork(): Second
    {
        $seconds = 0;

        foreach ($this->segments as $segment) {
            $seconds += $segment[0]->diffAsCarbonInterval($segment[1])->totalSeconds;
        }

        return Second::of($seconds);
    }

    public function toCreatePresences(): array
    {
        $r = [];

        foreach ($this->segments as $segment) {
            $r[] = new CreatePresence(
                date: $this->date,
                begin: $segment[0],
                isHomeOffice: $this->isHomeOffice,
                end: $segment[1],
            );
        }

        return $r;
    }

    public static function assumePause(Second $totalWorkDuration, Second $pause): Second
    {
        if (!self::isPauseValidForWorkDuration($totalWorkDuration, $pause)) {
            return self::calculateRequiredPause($totalWorkDuration);
        }

        return $pause;
    }

    public static function isPauseValidForWorkDuration(Second $totalWorkDuration, Second $pause): bool
    {
        if (self::calculateRequiredPause($totalWorkDuration)->isLessOrEqualThan($pause)) {
            return true;
        }

        return false;
    }

    public static function calculateRequiredPause(Second $totalWorkDuration): Second
    {
        $requiredPauseInSeconds = 0;

        if ($totalWorkDuration->toIndustryHours()->value > 6.00) {
            $requiredPauseInMinutes = 30;

            if ($totalWorkDuration->toIndustryHours()->value > 9.00) {
                $requiredPauseInMinutes = 45;
            }

            $requiredPauseInSeconds = $requiredPauseInMinutes * 60;
        }

        return Second::of($requiredPauseInSeconds);
    }

    public static function splitIntoSegments(Carbon $begin, Second $totalWorkDuration, Second $pause): array
    {
        $totalDurationInSeconds = $totalWorkDuration->value;
        $firstSegmentEndsAfterSeconds = $totalDurationInSeconds;
        $lengthOfSecondSegment = 0;

        $sixHoursInSeconds = 6 * 60 * 60;

        if ($totalDurationInSeconds >= $sixHoursInSeconds) {
            $firstSegmentEndsAfterSeconds = $sixHoursInSeconds;
            $lengthOfSecondSegment = $totalDurationInSeconds - $sixHoursInSeconds;
        }

        $segments = [[$begin, $begin->copy()->addSeconds($firstSegmentEndsAfterSeconds)]];

        // we need two segments
        if ($lengthOfSecondSegment > 0) {
            $endOfFirstSegment = $segments[0][1];
            $beginOfSecondSegment = $endOfFirstSegment->copy()->addSeconds($pause->value);
            $endOfSecondSegment = $beginOfSecondSegment->copy()->addSeconds($lengthOfSecondSegment);
            $segments[] = [$beginOfSecondSegment, $endOfSecondSegment];
        }

        return $segments;
    }

    public static function of(Carbon $dateWithBegin, Second $totalWorkDuration, Second $pause, bool $isHomeOffice = true): WorkDayPresence
    {
        if (!self::isPauseValidForWorkDuration($totalWorkDuration, $pause)) {
            throw new \Exception("Required pause interval is not valid");
        }

        $segments = self::splitIntoSegments($dateWithBegin, $totalWorkDuration, $pause);

        return new static($dateWithBegin, $segments, $isHomeOffice);
    }
}
