<?php

namespace Underscore\Method;

use Underscore\Collection;
use Underscore\UnderscoreMethod;

/**
 * Class WithoutMethod
 * @package Underscore\Method
 */
class WithoutMethod extends UnderscoreMethod
{
    /**
     * Removes all provided values using strict comparison.
     *
     * @param Collection   $collection
     * @param \ArrayAccess $values
     * @return Collection
     */
    public function __invoke($collection, $values)
    {
        $values   = $this->wrap($values);
        $contains = new ContainsMethod();
        $reject   = new RejectMethod();

        $iterator = function ($item) use ($values, $contains) {
            return $contains($values, $item)->value();
        };

        return $reject($collection, $iterator);
    }
}
