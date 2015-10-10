<?php

namespace Underscore\Mutator;

use Underscore\Collection;
use Underscore\Mutator;

class ThruMutator extends Mutator
{
    /**
     * Allows applying some operator to entire collection at once and returning it's result
     *
     * @param Collection $collection
     * @param callable   $iterator
     * @return Collection
     */
    public function __invoke($collection, $iterator)
    {
        return $this->wrap(call_user_func($iterator, $collection->toArray()));
    }
}
