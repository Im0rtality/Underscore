<?php

namespace Underscore\Accessor;

use Underscore\Accessor;
use Underscore\Collection;

class MinAccessor extends Accessor
{
    /**
     * Returns the smallest value in the collection.
     *
     * @param Collection $collection
     * @return mixed
     */
    public function __invoke(Collection $collection)
    {
        return min($collection->toArray());
    }
}
