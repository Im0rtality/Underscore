<?php

namespace Underscore\Mutator;

use Underscore\Collection;
use Underscore\Mutator;

class DefaultsMutator extends Mutator
{
    /**
     * Fill in null properties in object.
     *
     * Uses the first value present in any of the defaults.
     *
     * @param Collection $collection
     * @param mixed $default
     * @param ...
     * @return Collection
     */
    public function __invoke($collection, $default)
    {
        $defaults = func_get_args();
        array_shift($defaults); // remove $collection

        $collection = clone $collection;

        foreach ($defaults as $default) {
            foreach ($default as $key => $value) {
                if (!isset($collection[$key])) {
                    $collection[$key] = $value;
                }
            }
        }

        return $collection;
    }
}
