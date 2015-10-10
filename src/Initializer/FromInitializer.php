<?php

namespace Underscore\Initializer;

use Underscore\Collection;
use Underscore\Initializer;
use Underscore\Underscore;

class FromInitializer extends Initializer
{
    /**
     * Initializes Underscore object and sets argument as internal collection
     * @param mixed $item
     * @return Underscore
     */
    public function __invoke($item)
    {
        return new Underscore(new Collection($item));
    }
}
