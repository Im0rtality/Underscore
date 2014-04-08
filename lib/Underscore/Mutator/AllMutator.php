<?php

namespace Underscore\Mutator;

use Underscore\Collection;
use Underscore\Mutator;

/**
 * Class AllMethod
 * @package Underscore\Mutator
 */
class AllMutator extends Mutator
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

        $reduce = new ReduceMutator();

        return $reduce($collection, $iterator, true);
    }
}
