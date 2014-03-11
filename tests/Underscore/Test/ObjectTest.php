<?php

namespace Underscore\Test;

use Underscore\Underscore;

/**
 * Class UnderscoreObjectTest
 * @package Underscore\Test
 */
class UnderscoreObjectTest extends UnderscoreTest
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

    /**
     * @return object
     */
    protected function getDummy2()
    {
        $dummy = $this->getDummy();

        $dummy->false = false;
        $dummy->null  = null;
        $dummy->zero  = 0;

        return $dummy;
    }

    public function testToArray()
    {
        $value = Underscore::from($this->getDummy())->toArray();
        $this->assertSame(get_object_vars($this->getDummy()), $value);
    }
}
