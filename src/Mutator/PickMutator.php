<?php

namespace Underscore\Mutator;

use Underscore\Collection;
use Underscore\Mutator;

/**
 * Class PickMutator
 * @package Underscore\Mutator
 */
class PickMutator extends Mutator
{
    /**
     * Serves as shorthand to get list of specific key value from every element
     *
     * If key not found returns null
     *
     * @param Collection $collection
     * @param string|int $key
     * @return Collection
     */
    public function __invoke($collection, $key)
    {
        $iterator = function ($value) use ($key) {
            if (is_object($value)) {
                if (is_callable(array($value, $key))) {
                    return call_user_func(array($value, $key));
                } else {
                    return isset($value->{$key}) ? $value->{$key} : null;
                }
            } else {
                return isset($value[$key]) ? $value[$key] : null;
            }
        };

        $map = new MapMutator();

        return $map($collection, $iterator);
    }
}
