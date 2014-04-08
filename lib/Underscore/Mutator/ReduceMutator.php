<?php

namespace Underscore\Mutator;

use Underscore\Collection;
use Underscore\Mutator;

/**
 * Class ReduceMethod
 * @package Underscore\Mutator
 */
class ReduceMutator extends Mutator
{
    /**
     * Reduces collection to single value using $iterator
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

        foreach ($collection as $value) {
            $initial = call_user_func($iterator, $initial, $value);
        }

        return $this->wrap($initial);
    }
}
