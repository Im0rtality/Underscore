<?php

namespace Underscore\Accessor;

use Underscore\Accessor;
use Underscore\Collection;

/**
 * Class ValueAccessor
 * @package Underscore\Accessor
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
