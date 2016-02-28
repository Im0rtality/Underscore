<?php

namespace Underscore\Accessor;

use Underscore\Accessor;
use Underscore\Collection;

class IndexOfAccessor extends Accessor
{
    /**
     * Returns the key of the given value.
     *
     * @param Collection $collection
     * @return mixed
     */
    public function __invoke(Collection $collection, $value)
    {
        $values = $collection->toArray();
        return array_search($value, $values, true);
    }
}
