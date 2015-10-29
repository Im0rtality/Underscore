<?php

namespace Underscore\Initializer;

use Underscore\Collection;
use Underscore\Initializer;
use Underscore\Underscore;

class FromInitializer extends Initializer
{
    /**
     * Initializes Underscore object and sets argument as internal collection
     *
     * @param mixed $item
     * @return Underscore
     */
    public function __invoke($item)
    {
        if ($item instanceof Collection) {
            $item = clone $item;
        } else {
            $item = new Collection($item);
        }
        return new Underscore($item);
    }
}
