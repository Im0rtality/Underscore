<?php

namespace Underscore\Mutator;

use Underscore\Collection;
use Underscore\Mutator;

class MergeMutator extends Mutator
{
    /**
     * Merges two collections. If keys collide, new value overwrites older.
     *
     * @param Collection $collection
     * @param \Iterator  $values
     * @return Collection
     */
    public function __invoke($collection, $values)
    {
        $collection = clone $collection;

        foreach ($values as $key => $value) {
            $collection[$key] = $value;
        }

        return $collection;
    }
}
