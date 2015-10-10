<?php

namespace Underscore\Accessor;

use Underscore\Accessor;
use Underscore\Collection;

/**
 * @deprecated Use toArray() instead. Will be removed in later releases
 */
class ValueAccessor extends Accessor
{
    /**
     * Returns wrapped object
     *
     * @param Collection $collection
     * @return mixed
     */
    public function __invoke(Collection $collection)
    {
        return $collection->value();
    }
}
