<?php

namespace Underscore\Mutator;

use Underscore\Collection;
use Underscore\Mutator;

/**
 * Class SortByMutator
 * @package Underscore\Mutator
 */
class SortByMutator extends Mutator
{
    /**
     * Creates an array of elements, sorted in ascending order by the results
     * of running each element in a collection through the callback
     *
     * When values returned by $callback are equal the order is undefined (i.e. the sort is not stable)
     *
     * @param Collection $collection
     * @param callable   $iterator
     * @return Collection
     */
    public function __invoke($collection, $iterator)
    {
        $sortFunc = function ($value) {
            sort($value);
            return $value;
        };

        /** @var $collection Collection */
        /** @noinspection PhpParamsInspection */
        $collection = call_user_func(new GroupByMutator(), $collection, $iterator);

        // read once - for performance
        $val = $collection->value();

        $mapFunc = function ($key) use ($val) {
            return $val[$key];
        };

        /** @noinspection PhpParamsInspection */
        $collection = call_user_func(new KeysMutator(), $collection);
        /** @noinspection PhpParamsInspection */
        $collection = call_user_func(new TapMutator(), $collection, $sortFunc);
        /** @noinspection PhpParamsInspection */
        $collection = call_user_func(new MapMutator(), $collection, $mapFunc);
        /** @noinspection PhpParamsInspection */
        $collection = call_user_func(new FlattenMutator(), $collection);

        return $collection;
    }
}
