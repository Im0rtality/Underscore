<?php

namespace Underscore\Mutator;

use Underscore\Collection;
use Underscore\Mutator;

class IntersectionMutator extends Mutator
{
    /**
     * Intersects two collections.
     *
     * @param Collection $collection
     * @param \Iterator  $values
     * @return Collection
     */
    public function __invoke($collection, $values)
    {
        $collection = clone $collection;

        if (!is_array($values)) {
            $values = iterator_to_array($values);
        }

        $collection->exchangeArray(array_intersect(
            $collection->getArrayCopy(),
            $values
        ));

        return $collection;
    }
}
