<?php

namespace Underscore\Test;

/**
 * Class UnderscoreObjectTest
 * @package Underscore\Test
 */
class UnderscoreObjectTest extends MasterTest
{
    /**
     * @inheritDoc
     */
    protected function getDummy()
    {
        $dummy       = new \stdClass();
        $dummy->name = 'dummy';
        $dummy->foo  = 'bar';
        $dummy->baz  = 'qux';

        return $dummy;
    }
}
