<?php

namespace Underscore;

/**
 * Class UnderscoreMethod
 * @package Underscore
 */
class Mutator
{
    /**
     * @param mixed $item
     * @return Collection
     */
    protected function wrap($item)
    {
        return new Collection($item);
    }
}
