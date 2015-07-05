<?php

namespace Underscore\Accessor;

use Underscore\Accessor;
use Underscore\Collection;

/**
 * Class SizeAccessor
 * @package Underscore\Accessor
 */
class SizeAccessor extends Accessor
{
    /**
     * Gets the size of the collection by returning length for arrays or number of enumerable properties for objects.
     *
     * @param Collection $collection
     * @return int
     */
    public function __invoke(Collection $collection)
    {
        return $collection->count();
    }
}
