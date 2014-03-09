<?php

namespace Underscore\Test;

use Underscore\Underscore;

/**
 * Class UnderscoreArrayTest
 * @package Underscore\Test
 */
class UnderscoreArrayTest extends MasterTest
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

    public function testToArray()
    {
        $value = Underscore::from($this->getDummy())->toArray();
        $this->assertSame($this->getDummy(), $value);
    }
}
