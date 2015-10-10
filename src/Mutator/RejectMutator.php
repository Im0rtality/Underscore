<?php

namespace Underscore\Mutator;

use Underscore\Collection;
use Underscore\Mutator;

class RejectMutator extends Mutator
{
    /**
     * The opposite of filter(). This mutator returns the elements of a collection that the callback
     * does **not** return truey for.
     *
     * @param Collection $collection
     * @param callable   $iterator
     * @return Collection
     */
    public function __invoke($collection, $iterator)
    {
        $not = function ($iterator) {
            return function () use ($iterator) {
                return !call_user_func_array($iterator, func_get_args());
            };
        };

        return $this->wrap(array_filter((array)$collection, $not($iterator)));
    }
}
