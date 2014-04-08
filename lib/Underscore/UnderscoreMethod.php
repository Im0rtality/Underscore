<?php

namespace Underscore;

/**
 * Class UnderscoreMethod
 * @package Underscore
 */
class UnderscoreMethod
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
