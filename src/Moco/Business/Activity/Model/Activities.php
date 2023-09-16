<?php
declare(strict_types=1);

namespace Dreitier\Moco\Business\Activity\Model;

use Dreitier\Moco\Business\Models;
use Illuminate\Support\Collection;

class Activities extends Models
{
    public static function unwrap(array $data)
    {
        return new Activities(collect($data)->map(fn($item) => Activity::unwrap($item))->toArray());
    }

    public function groupByDay(): Collection
    {
        return $this->collection()->mapToGroups(fn($item) => [$item->date->format('Y-m-d') => $item]);
    }
}
