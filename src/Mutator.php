<?php

namespace Underscore;

abstract class Mutator
{
    /**
     * Get a copy of a collection with new values.
     *
     * @param Collection $collection
     * @param array $values
     * @return Collection
     */
    protected function copyCollectionWith(Collection $collection, array $values)
    {
        $collection = clone $collection;

        $collection->exchangeArray($values);

        return $collection;
    }
}
