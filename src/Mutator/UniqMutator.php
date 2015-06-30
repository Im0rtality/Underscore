<?php

namespace Underscore\Mutator;

use Underscore\Collection;
use Underscore\Mutator;

/**
 * Class UniqMutator
 * @package Underscore\Mutator
 */
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
        $collection = clone $collection;

        $seen = array();
        foreach ($collection as $k => $v) {
            if (in_array($v, $seen, true)) {
                unset($collection[$k]);
            } else {
                $seen[] = $v;
            }
        }

        return $collection;
    }
}
