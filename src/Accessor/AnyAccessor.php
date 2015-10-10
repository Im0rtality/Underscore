<?php

namespace Underscore\Accessor;

use Underscore\Accessor;
use Underscore\Collection;

class AnyAccessor extends Accessor
{
    /**
     * Checks if the $iterator returns a truey value for ANY element of a collection.
     * The function returns as soon as it finds a passing value and does not iterate
     * over entire collection.
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
            $accumulator = $accumulator || $iterator($item);

            return $accumulator;
        };

        $reduce = new ReduceAccessor();

        return $reduce($collection, $iterator, false);
    }
}
