<?php

namespace Underscore\Accesor;

use Underscore\Accesor;
use Underscore\Collection;

/**
 * Class ToArrayAccesor
 * @package Underscore\Accesor
 */
class ToArrayAccesor extends Accesor
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
