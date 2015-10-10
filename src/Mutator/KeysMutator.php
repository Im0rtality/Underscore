<?php

namespace Underscore\Mutator;

use Underscore\Collection;
use Underscore\Mutator;

class KeysMutator extends Mutator
{
    /**
     * Creates an collection composed of the enumerable property keys of object.
     *
     * @SuppressWarnings(UnusedLocalVariable) - $value in foreach
     *
     * @param Collection $collection
     * @return Collection
     */
    public function __invoke($collection)
    {
        $newCollection = [];

        foreach ($collection as $key => $value) {
            $newCollection[] = $key;
        }

        return $this->wrap($newCollection);
    }
}
