<?php

namespace Underscore\Method;

use Underscore\Collection;
use Underscore\UnderscoreMethod;

/**
 * Class InitialMethod
 * @package Underscore\Method
 */
class InitialMethod extends UnderscoreMethod
{
    /**
     * Gets all but the last element or last n elements of collection.
     *
     * Returns mixed[]
     *
     * @param Collection $collection
     * @param int        $count
     * @return Collection
     */
    public function __invoke($collection, $count = 1)
    {
        return $this->wrap(array_slice($collection->toArray(), 0, -$count));
    }
}
