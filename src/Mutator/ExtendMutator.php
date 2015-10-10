<?php

namespace Underscore\Mutator;

use Underscore\Collection;
use Underscore\Mutator;

class ExtendMutator extends Mutator
{
    /**
     * Copy all of the properties in the source objects over to the destination object.
     *
     * It's in-order, so the last source will override properties of the same name
     * in previous arguments.
     *
     * @param Collection $collection
     * @param mixed $source
     * @param ...
     * @return Collection
     */
    public function __invoke($collection, $source)
    {
        $sources = func_get_args();
        array_shift($sources); // remove $collection

        $collection = clone $collection;

        foreach ($sources as $source) {
            foreach ($source as $key => $value) {
                $collection[$key] = $value;
            }
        }

        return $collection;
    }
}
