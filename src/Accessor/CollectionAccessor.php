<?php

namespace Underscore\Accessor;

use Underscore\Accessor;
use Underscore\Collection;

class CollectionAccessor extends Accessor
{
    /**
     * Returns a copy of the collection
     *
     * @param Collection $collection
     * @return mixed
     */
    public function __invoke(Collection $collection)
    {
        return clone $collection;
    }
}
