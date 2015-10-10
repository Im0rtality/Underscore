<?php

namespace Underscore\Mutator;

use Underscore\Accessor\ContainsAccessor;
use Underscore\Collection;
use Underscore\Mutator;

class WithoutMutator extends Mutator
{
    /**
     * Removes all provided values using strict comparison.
     *
     * @param Collection   $collection
     * @param \ArrayAccess $values
     * @return Collection
     */
    public function __invoke($collection, $values)
    {
        $values   = $this->wrap($values);
        $contains = new ContainsAccessor();
        $reject   = new RejectMutator();

        $iterator = function ($item) use ($values, $contains) {
            return $contains($values, $item);
        };

        return $reject($collection, $iterator);
    }
}
