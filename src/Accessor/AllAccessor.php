<?php

namespace Underscore\Accessor;

use Underscore\Accessor;
use Underscore\Collection;

class AllAccessor extends Accessor
{
    /**
     * Checks if the $iterator returns a truey value for ALL element of a collection.
     *
     * Returns boolean
     *
     * @param Collection $collection
     * @param callable   $iterator
     * @return Collection
     */
    public function __invoke($collection, $iterator)
    {
        $iterator = function ($accumulator, $item) use ($iterator) {
            $accumulator = $accumulator && $iterator($item);
            return $accumulator;
        };

        $reduce = new ReduceAccessor();

        return $reduce($collection, $iterator, true);
    }
}
