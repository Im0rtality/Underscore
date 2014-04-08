<?php

namespace Underscore\Method;

use Underscore\Collection;
use Underscore\UnderscoreMethod;

/**
 * Class AllMethod
 * @package Underscore\Method
 */
class AllMethod extends UnderscoreMethod
{
    /**
     * Checks if the $iterator returns a truey value for ALL element of a collection.
     *
     * Returns boolean
     *
     * @param Collection $collection
     * @param callable   $iterator
     * @return Collection
     */
    public function __invoke($collection, $iterator)
    {
        $iterator = function ($accumulator, $item) use ($iterator) {
            $accumulator = $accumulator && $iterator($item);
            return $accumulator;
        };

        $reduce = new ReduceMethod();

        return $reduce($collection, $iterator, true);
    }
}
