<?php

namespace Underscore\Accessor;

use Underscore\Accessor;
use Underscore\Collection;

/**
 * Class MaxAccessor
 * @package Underscore\Accessor
 */
class MaxAccessor extends Accessor
{
    /**
     * Returns the largest value in the collection.
     *
     * @param Collection $collection
     * @return mixed
     */
    public function __invoke(Collection $collection)
    {
        return max($collection->toArray());
    }
}
