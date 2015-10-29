<?php

namespace Underscore\Mutator;

use Underscore\Collection;
use Underscore\Mutator;

class WhereMutator extends Mutator
{
    /**
     * Remove all values that do not match the given key-value pairs.
     *
     * By default strict comparison is used.
     *
     * @param Collection $collection
     * @param array      $properties
     * @param boolean    $strict
     * @return Collection
     */
    public function __invoke($collection, array $properties, $strict = true)
    {
        $filter = new FilterMutator;

        return $filter($collection, function ($item) use ($properties, $strict) {
            foreach ($properties as $key => $value) {
                if (empty($item[$key])
                    || ($strict && $item[$key] !== $value)
                    || (!$strict && $item[$key] != $value)
                ) {
                    return false;
                }
            }

            return true;
        });
    }
}
