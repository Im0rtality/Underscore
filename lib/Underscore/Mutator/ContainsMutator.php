<?php

namespace Underscore\Mutator;

use Underscore\Collection;
use Underscore\Mutator;

/**
 * Class ContainsMethod
 * @package Underscore\Mutator
 */
class ContainsMutator extends Mutator
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

        $find = new FindMutator();

        return $find($collection, $iterator);
    }
}
