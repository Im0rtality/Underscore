<?php

namespace Underscore\Mutator;

use Underscore\Collection;
use Underscore\Mutator;

/**
 * Class InitialMutator
 * @package Underscore\Mutator
 */
class InitialMutator extends Mutator
{
    /**
     * Gets all but the last element or last n elements of collection.
     *
     * Returns mixed[]
     *
     * @param Collection $collection
     * @param int        $count
     * @return Collection
     */
    public function __invoke($collection, $count = 1)
    {
        return $this->wrap(array_slice($collection->toArray(), 0, -$count));
    }
}
