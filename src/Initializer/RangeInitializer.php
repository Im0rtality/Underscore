<?php

namespace Underscore\Initializer;

use Underscore\Collection;
use Underscore\Initializer;
use Underscore\Underscore;

class RangeInitializer extends Initializer
{
    /**
     * Creates Underscore object containing array of numbers
     *
     * @param int $start Start number, inclusive
     * @param int $stop  Stop number, not inclusive
     * @param int $step  Step size, non-zero, can be negative
     *
     * @throws \LogicException
     * @return Underscore
     */
    public function __invoke($start, $stop, $step = 1)
    {
        if (0 == $step) {
            throw new \LogicException('$step have to be non-zero');
        }

        $array = array();

        for ($i = (int)$start; $i < (int)$stop; $i += (int)$step) {
            $array[] = $i;
        }

        return new Underscore(new Collection($array));
    }
}
