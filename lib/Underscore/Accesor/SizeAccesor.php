<?php

namespace Underscore\Accesor;

use Underscore\Accesor;
use Underscore\Collection;

/**
 * Class SizeAccesor
 * @package Underscore\Accesor
 */
class SizeAccesor extends Accesor
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
