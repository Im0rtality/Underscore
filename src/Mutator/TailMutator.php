<?php

namespace Underscore\Mutator;

use Underscore\Collection;
use Underscore\Mutator;

class TailMutator extends Mutator
{
    /**
     * Gets all but the first element or first n elements of collection.
     *
     * Returns mixed[]
     *
     * @param Collection $collection
     * @param int        $count
     * @return Collection
     */
    public function __invoke($collection, $count = 1)
    {
        $values = array_slice($collection->toArray(), $count);

        return $this->copyCollectionWith($collection, $values);
    }
}
