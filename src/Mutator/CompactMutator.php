<?php

namespace Underscore\Mutator;

use Underscore\Collection;
use Underscore\Functions;
use Underscore\Mutator;

class CompactMutator extends Mutator
{
    /**
     * Removes all falsey values.
     *
     * @param Collection $collection
     * @return Collection
     */
    public function __invoke($collection)
    {
        $filter = new FilterMutator();

        return $filter($collection, Functions::nop());
    }
}
