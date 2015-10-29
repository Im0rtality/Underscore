<?php

namespace Underscore\Mutator;

use Underscore\Collection;
use Underscore\Mutator;

class ValuesMutator extends Mutator
{
    /**
     * Creates an collection composed of the enumerable property values of object.
     *
     * @param Collection $collection
     * @return Collection
     */
    public function __invoke($collection)
    {
        $values = array_values($collection->toArray());

        return $this->copyCollectionWith($collection, $values);
    }
}
