<?php

namespace Underscore\Mutator;

use Underscore\Collection;
use Underscore\Mutator;

/**
 * Class GroupByMutator
 * @package Underscore\Mutator
 */
class GroupByMutator extends Mutator
{
    /**
     * Creates an object composed of keys generated from the results
     * of running each element of a collection through the callback
     *
     * @param Collection $collection
     * @param callable   $iterator
     * @return Collection
     */
    public function __invoke($collection, $iterator)
    {
        $newCollection = array();

        foreach ($collection as $value) {
            $newCollection[call_user_func($iterator, $value)][] = $value;
        }

        return $this->wrap($newCollection);
    }
}
