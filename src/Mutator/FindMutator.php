<?php

namespace Underscore\Mutator;

use Underscore\Collection;
use Underscore\Mutator;

/**
 * Class FindMutator
 * @package Underscore\Mutator
 */
class FindMutator extends Mutator
{
    /**
     * Iterates over elements of a collection, returning the first element that the callback returns truey for.
     *
     * Returns mixed
     *
     * @param Collection $collection
     * @param callable   $iterator
     * @return Collection
     */
    public function __invoke($collection, $iterator)
    {
        $collection = clone $collection;

        $found = false;
        foreach ($collection as $k => $v) {
            if (call_user_func($iterator, $v, $k, $collection)) {
                $found = true;
                break;
            }
        }

        return $this->wrap($found);
    }
}
