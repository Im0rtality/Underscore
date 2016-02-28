<?php

namespace Underscore\Mutator;

use Underscore\Collection;
use Underscore\Mutator;

class KeysMutator extends Mutator
{
    /**
     * Creates an collection composed of the enumerable property keys of object.
     *
     * @param Collection $collection
     * @return Collection
     */
    public function __invoke($collection)
    {
        $values = array_keys($collection->toArray());

        return $this->copyCollectionWith($collection, $values);
    }
}
