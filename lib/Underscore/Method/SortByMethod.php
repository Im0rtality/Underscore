<?php

namespace Underscore\Method;

use Underscore\Collection;
use Underscore\UnderscoreMethod;

/**
 * Class SortByMethod
 * @package Underscore\Method
 */
class SortByMethod extends UnderscoreMethod
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
        $collection = call_user_func(new GroupByMethod(), $collection, $iterator);

        // read once - for performance
        $val = $collection->value();

        $mapFunc = function ($key) use ($val) {
            return $val[$key];
        };

        /** @noinspection PhpParamsInspection */
        $collection = call_user_func(new KeysMethod(), $collection);
        /** @noinspection PhpParamsInspection */
        $collection = call_user_func(new TapMethod(), $collection, $sortFunc);
        /** @noinspection PhpParamsInspection */
        $collection = call_user_func(new MapMethod(), $collection, $mapFunc);
        /** @noinspection PhpParamsInspection */
        $collection = call_user_func(new FlattenMethod(), $collection);

        return $collection;
    }
}
