<?php
declare(strict_types=1);

namespace Dreitier\Temporal;

class Number
{
    public function __construct(public readonly float $value)
    {
    }

    public function isPositive(): bool
    {
        return $this->value > 0;
    }

    public function isNegative(): bool
    {
        return $this->value < 0;
    }

    public function isZero(): bool
    {
        return $this->value === (float)0.0;
    }

    public function isNotZero(): bool
    {
        return !$this->isZero();
    }

    public function sign(): string
    {
        if ($this->isPositive()) {
            return "+";
        }

        if ($this->isNegative()) {
            return "-";
        }

        return "";
    }

    public function equals(Number $other)
    {
        return $this->value == $other->value;
    }

    public function isLessOrEqualThan(Number $other)
    {
        return $this->value <= $other->value;
    }
}
