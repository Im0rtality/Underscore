<?php

namespace Underscore\Method;

use Underscore\Collection;
use Underscore\UnderscoreMethod;

/**
 * Class HeadMethod
 * @package Underscore\Method
 */
class HeadMethod extends UnderscoreMethod
{
    /**
     * Gets the first element or first n elements of collection.
     *
     * Returns mixed[]
     *
     * @param Collection $collection
     * @param int        $count
     * @return Collection
     */
    public function __invoke($collection, $count = 1)
    {
        return $this->wrap(array_slice($collection->toArray(), 0, $count));
    }
}
