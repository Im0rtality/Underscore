<?php

namespace Underscore\Accessor;

use Underscore\Accessor;
use Underscore\Collection;

class ToArrayAccessor extends Accessor
{
    /**
     * Returns wrapped object as an array
     *
     * @param Collection $collection
     * @return mixed
     */
    public function __invoke(Collection $collection)
    {
        return $collection->toArray();
    }
}
