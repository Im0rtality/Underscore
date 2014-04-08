<?php

namespace Underscore\Mutator;

use Underscore\Collection;
use Underscore\Mutator;

/**
 * Class InvokeMutator
 * @package Underscore\Mutator
 */
class InvokeMutator extends Mutator
{
    /**
     * Call $iterator for each element
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
            call_user_func($iterator, $v, $k, $collection);
        }

        return $collection;
    }
}
