<?php

namespace Underscore\Mutator;

use Underscore\Collection;
use Underscore\Mutator;

/**
 * Class WhereMutator
 * @package Underscore\Mutator
 */
class WhereMutator extends Mutator
{
    /**
     * Remove all values that do not match the given key-value pairs.
     *
     * By default strict comparison is used.
     *
     * @param Collection $collection
     * @param array $properties
     * @param boolean $strict
     * @return Collection
     */
    public function __invoke($collection, array $properties, $strict = true)
    {
        $collection = clone $collection;

        // This can be refactored to use array_filter once #54 is merged.
        foreach ($collection as $index => $item) {
            $item = new Collection($item);
            foreach ($properties as $key => $value) {
                if (empty($item[$key])
                    || ($strict && $item[$key] !== $value)
                    || (!$strict && $item[$key] != $value)
                ) {
                    unset($collection[$index]);
                }
            }
        }

        return $collection;
    }
}
