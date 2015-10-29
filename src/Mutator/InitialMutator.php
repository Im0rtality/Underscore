<?php

namespace Underscore\Mutator;

use Underscore\Collection;
use Underscore\Mutator;

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
        $values = array_slice($collection->toArray(), 0, -$count);

        return $this->copyCollectionWith($collection, $values);
    }
}
