<?php

namespace Underscore\Initializer;

use Underscore\Collection;
use Underscore\Initializer;
use Underscore\Underscore;

class TimesInitializer extends Initializer
{
    /**
     * Invokes the given iteratee function n times.
     *
     * Each invocation of iteratee is called with an index argument. Produces a
     * Collection of the returned values.
     *
     * @param integer $count
     * @param callable $function
     * @return Underscore
     */
    public function __invoke($count, $function /*, $context */)
    {
        // Context switching is possible in PHP 5.4 by using Closure::bind.

        $results = array();
        for ($i = 0; $i < $count; $i++) {
            $results[] = $function($i);
        }

        return new Underscore(new Collection($results));
    }
}
