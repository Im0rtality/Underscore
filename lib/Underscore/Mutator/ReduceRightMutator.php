<?php

namespace Underscore\Mutator;

use Underscore\Collection;
use Underscore\Mutator;

/**
 * Class ReduceRightMutator
 * @package Underscore\Mutator
 */
class ReduceRightMutator extends Mutator
{
    /**
     * Reduces collection to single value using $iterator. Reversed direction.
     *
     * $iterator = function($accumulator, $value)
     *
     * @param Collection $collection
     * @param callable   $iterator
     * @param mixed      $initial
     * @return Collection
     */
    public function __invoke($collection, $iterator, $initial = null)
    {
        $collection = clone $collection;

        foreach ($collection->getIteratorReversed() as $value) {
            $initial = call_user_func($iterator, $initial, $value);
        }

        return $this->wrap($initial);
    }
}
