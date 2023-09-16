<?php
declare(strict_types=1);

namespace Dreitier\Moco\Business\Absence\Model;

class AbsenceCode
{
    const UNPLANNABLE_ABSENCE = 1;
    const PUBLIC_HOLIDAY = 2;
    const SICK_DAY = 3;
    const HOLIDAY = 4;
    const ABSENCE = 5;

    private function __construct(
        public readonly int    $value,
        public readonly string $name,
        public readonly string $type = 'Absence',
    )
    {
    }

    public static function fromCode(int $id): ?AbsenceCode
    {
        switch ($id) {
            case static::UNPLANNABLE_ABSENCE:
                return new static(static::UNPLANNABLE_ABSENCE, 'Ungeplante Abwesenheit');
            case static::PUBLIC_HOLIDAY:
                return new static(static::PUBLIC_HOLIDAY, 'Feiertag');
            case static::SICK_DAY:
                return new static(static::SICK_DAY, 'Krankheit');
            case static::HOLIDAY:
                return new static(static::HOLIDAY, 'Urlaub');
            case static::ABSENCE:
                return new static(static::ABSENCE, 'Abwesenheit');
            default:
                return null;
        }
    }

    public static function fromNameAndType(string $name, string $type): ?AbsenceCode
    {
        if (strtolower($type) !== 'absence') {
            return null;
        }

        $nameToCompare = strtolower($name);

        switch ($nameToCompare) {
            case 'unplannable absence':
            case 'ungeplante abwesenheit':
                return new AbsenceCode(static::UNPLANNABLE_ABSENCE, $name);
            case 'public holiday':
            case 'feiertag':
                return new AbsenceCode(static::PUBLIC_HOLIDAY, $name);
            case 'sick day':
            case 'krankheit':
                return new AbsenceCode(static::SICK_DAY, $name);
            case 'holiday':
            case 'urlaub':
                return new AbsenceCode(static::HOLIDAY, $name);
            case 'absence':
            case 'abwesenheit':
                return new AbsenceCode(static::ABSENCE, $name);

            default:
                return null;
        }
    }
}
