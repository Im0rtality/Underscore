<?php

namespace Underscore\Method;

use Underscore\Collection;
use Underscore\Functions;
use Underscore\UnderscoreMethod;

/**
 * Class CompactMethod
 * @package Underscore\Method
 */
class CompactMethod extends UnderscoreMethod
{
    /**
     * Removes all falsey values.
     *
     * @param Collection $collection
     * @return Collection
     */
    public function __invoke($collection)
    {
        $filter = new FilterMethod();

        return $filter($collection, Functions::nop());
    }
}
