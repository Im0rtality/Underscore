<?php

namespace Underscore\Mutator;

use Underscore\Collection;
use Underscore\Mutator;

/**
 * Class MapMutator
 * @package Underscore\Mutator
 */
class MapMutator extends Mutator
{
    /**
     * Replaces every element with value returned by individual $iterator call
     *
     * $iterator = function($value, $key, $collection)
     *
     * @param Collection $collection
     * @param callable   $iterator
     * @return Collection
     */
    public function __invoke($collection, $iterator)
    {
        $collection = clone $collection;

        foreach ($collection as $k => $v) {
            $collection[$k] = call_user_func($iterator, $v, $k, $collection);
        }

        return $collection;
    }
}
