<?php

namespace Underscore\Method;

use Underscore\Collection;
use Underscore\UnderscoreMethod;

/**
 * Class LastMethod
 * @package Underscore\Method
 */
class LastMethod extends UnderscoreMethod
{
    /**
     * Gets the last element or last n elements of collection.
     *
     * Returns mixed[]
     *
     * @param Collection $collection
     * @param int        $count
     * @return Collection
     */
    public function __invoke($collection, $count = 1)
    {
        return $this->wrap(array_slice($collection->toArray(), -$count));
    }
}
