<?php

namespace Underscore\Method;

use Underscore\Collection;
use Underscore\UnderscoreMethod;

/**
 * Class TapMethod
 * @package Underscore\Method
 */
class TapMethod extends UnderscoreMethod
{
    /**
     * Invokes $callback with the wrapped value of collection as the first argument
     * and then wraps it back.
     *
     * The purpose of this method is to "tap into" a method chain in order to
     * perform operations on intermediate results within the chain.
     *
     * @param Collection $collection
     * @param callable   $iterator
     * @return Collection
     */
    public function __invoke($collection, $iterator)
    {
        return $this->wrap(call_user_func($iterator, $collection->value()));
    }
}
