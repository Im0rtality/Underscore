<?php

namespace Underscore\Mutator;

use Underscore\Collection;
use Underscore\Mutator;

class FlattenMutator extends Mutator
{
    /**
     * Performs shallow flatten operation on collection (unwraps first level of array)
     *
     * @param Collection $collection
     * @return Collection
     */
    public function __invoke($collection)
    {
        $newCollection = [];

        foreach ($collection as $value) {
            $newCollection = array_merge($newCollection, is_array($value) ? $value : [$value]);
        }

        return $this->copyCollectionWith($collection, $newCollection);
    }
}
