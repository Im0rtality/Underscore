<?php

namespace Underscore\Mutator;

use Underscore\Collection;
use Underscore\Mutator;

class CloneMutator extends Mutator
{
    /**
     * Makes clone of collection
     *
     * @param Collection $collection
     * @return Collection
     */
    public function __invoke($collection)
    {
        return clone $collection;
    }
}
