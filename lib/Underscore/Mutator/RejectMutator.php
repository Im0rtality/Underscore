<?php

namespace Underscore\Mutator;

use Underscore\Collection;
use Underscore\Mutator;

/**
 * Class RejectMutator
 * @package Underscore\Mutator
 */
class RejectMutator extends Mutator
{
    /**
     * The opposite of filter(). This Mutator
     * returns the elements of a collection that the callback
     * does **not** return truey for.
     *
     * @param Collection $collection
     * @param callable   $iterator
     * @return Collection
     */
    public function __invoke($collection, $iterator)
    {
        $collection = clone $collection;

        foreach ($collection as $k => $v) {
            if (call_user_func($iterator, $v, $k)) {
                unset($collection[$k]);
            }
        }

        return $collection;
    }
}
