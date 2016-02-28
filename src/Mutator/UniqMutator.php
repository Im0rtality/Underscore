<?php

namespace Underscore\Mutator;

use Underscore\Collection;
use Underscore\Mutator;

class UniqMutator extends Mutator
{
    /**
     * Removes duplicate items from the collection.
     *
     * @param Collection $collection
     * @return Collection
     */
    public function __invoke($collection)
    {
        $seen = [];
        foreach ($collection as $k => $v) {
            if (!in_array($v, $seen, true)) {
                $seen[$k] = $v;
            }
        }

        return $this->copyCollectionWith($collection, $seen);
    }
}
