<?php

namespace Underscore\Method;

use Underscore\Collection;
use Underscore\UnderscoreMethod;

/**
 * Class ContainsMethod
 * @package Underscore\Method
 */
class ContainsMethod extends UnderscoreMethod
{
    /**
     * Checks if a given value is present in a collection using strict equality for comparisons.
     *
     * Returns bool
     *
     * @param Collection $collection
     * @param mixed      $needle
     * @return Collection
     */
    public function __invoke($collection, $needle)
    {
        $iterator = function ($value) use ($needle) {
            return $value === $needle;
        };

        $find = new FindMethod();

        return $find($collection, $iterator);
    }
}
