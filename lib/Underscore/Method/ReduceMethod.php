<?php

namespace Underscore\Method;

use Underscore\Collection;
use Underscore\UnderscoreMethod;

/**
 * Class ReduceMethod
 * @package Underscore\Method
 */
class ReduceMethod extends UnderscoreMethod
{
    /**
     * Reduces collection to single value using $iterator
     *
     * $iterator = function($accumulator, $value)
     *
     * @param Collection $collection
     * @param callable   $iterator
     * @param mixed      $initial
     * @return Collection
     */
    public function __invoke($collection, $iterator, $initial = null)
    {
        $collection = clone $collection;

        foreach ($collection as $value) {
            $initial = call_user_func($iterator, $initial, $value);
        }

        return $this->wrap($initial);
    }
}
