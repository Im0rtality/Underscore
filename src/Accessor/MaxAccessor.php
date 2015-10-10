<?php

namespace Underscore\Accessor;

use Underscore\Accessor;
use Underscore\Collection;

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
