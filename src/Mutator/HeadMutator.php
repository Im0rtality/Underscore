<?php

namespace Underscore\Mutator;

use Underscore\Collection;
use Underscore\Mutator;

class HeadMutator extends Mutator
{
    /**
     * Gets the first element or first n elements of collection.
     *
     * Returns mixed[]
     *
     * @param Collection $collection
     * @param int        $count
     * @return Collection
     */
    public function __invoke($collection, $count = 1)
    {
        $values = array_slice($collection->toArray(), 0, $count);

        return $this->copyCollectionWith($collection, $values);
    }
}
