<?php

namespace Underscore\Test\Fixture\Mutator;

use Underscore\Mutator;

/**
 * @codeCoverageIgnore
 */
class ChefMutator extends Mutator
{
    public function __invoke($collection)
    {
        $collection = clone $collection;
        $collection['chef'] = 'Bork! Bork! Bork!';
        return $collection;
    }
}
