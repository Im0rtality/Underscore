<?php

namespace Underscore\Accessor;

use Underscore\Accessor;
use Underscore\Collection;

/**
 * Class HasAccessor
 * @package Underscore\Accessor
 */
class HasAccessor extends Accessor
{
    /**
     * Determine if the given key exists in the collection.
     *
     * @param Collection $collection
     * @param string $key
     * @return mixed
     */
    public function __invoke(Collection $collection, $key)
    {
        return $collection->offsetExists($key);
    }
}
