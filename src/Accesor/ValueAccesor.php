<?php

namespace Underscore\Accesor;

use Underscore\Accesor;
use Underscore\Collection;

/**
 * Class ValueAccesor
 * @package Underscore\Accesor
 */
class ValueAccesor extends Accesor
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
