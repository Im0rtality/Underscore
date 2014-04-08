<?php

namespace Underscore\Method;

use Underscore\Collection;
use Underscore\UnderscoreMethod;

/**
 * Class MergeMethod
 * @package Underscore\Method
 */
class MergeMethod extends UnderscoreMethod
{
    /**
     * Merges two collections. If keys collide, new value overwrites older.
     *
     * @param Collection   $collection
     * @param \ArrayAccess $values
     * @return Collection
     */
    public function __invoke($collection, $values)
    {
        $collection = clone $collection;

        foreach ($values as $key => $value) {
            $collection[$key] = $value;
        }

        return $collection;
    }
}
