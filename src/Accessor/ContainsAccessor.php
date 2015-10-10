<?php

namespace Underscore\Accessor;

use Underscore\Accessor;
use Underscore\Collection;

class ContainsAccessor extends Accessor
{
    /**
     * Checks if a given value is present in a collection using strict equality for comparisons.
     *
     * Returns bool
     *
     * @param Collection $collection
     * @param mixed      $needle
     * @return Collection
     */
    public function __invoke($collection, $needle)
    {
        $iterator = function ($value) use ($needle) {
            return $value === $needle;
        };

        $find = new FindAccessor();

        return $find($collection, $iterator);
    }
}
