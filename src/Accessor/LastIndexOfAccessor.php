<?php

namespace Underscore\Accessor;

use Underscore\Accessor;
use Underscore\Collection;

class LastIndexOfAccessor extends Accessor
{
    /**
     * Returns the key of the given value, in the last possible position.
     *
     * @param Collection $collection
     * @return mixed
     */
    public function __invoke(Collection $collection, $value)
    {
        $values = array_reverse($collection->toArray(), true);
        return array_search($value, $values, true);
    }
}
