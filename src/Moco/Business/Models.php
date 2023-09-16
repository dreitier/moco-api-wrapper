<?php
declare(strict_types=1);

namespace Dreitier\Moco\Business;

use Illuminate\Support\Collection;
use IteratorAggregate;
use Traversable;

class Models implements IteratorAggregate
{
    protected function __construct(public readonly array $data, public readonly ?string $classType = null)
    {
    }

    public function getIterator(): Traversable
    {
        return new \ArrayIterator($this->data);
    }

    public function collection(): Collection
    {
        return collect($this->data);
    }

    public function total(): int
    {
        return sizeof($this->data);
    }

    public function last(): object|null
    {
        if ($this->total() > 0) {
            return $this->data[$this->total() - 1];
        }

        return null;
    }

    public static function of(array|Collection $collection, ?string $classType = null): Models
    {
        if ($collection instanceof Collection) {
            $collection = $collection->toArray();
        }

        return new static($collection, $classType);
    }
}
