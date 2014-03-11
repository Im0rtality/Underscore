<?php

namespace Underscore\Test;

use Underscore\Underscore;

/**
 * Class UnderscoreArrayTest
 * @package Underscore\Test
 */
class UnderscoreArrayTest extends UnderscoreTest
{
    /**
     * @inheritDoc
     */
    protected function getDummy()
    {
        $dummy = array(
            'name' => 'dummy',
            'foo'  => 'bar',
            'baz'  => 'qux',
        );

        return $dummy;
    }

    /**
     * @return mixed[]
     */
    protected function getDummy2()
    {
        $dummy = $this->getDummy();

        $dummy['false'] = false;
        $dummy['null']  = null;
        $dummy['zero']  = 0;

        return $dummy;
    }

    public function testToArray()
    {
        $value = Underscore::from($this->getDummy())->toArray();
        $this->assertSame($this->getDummy(), $value);
    }
}
