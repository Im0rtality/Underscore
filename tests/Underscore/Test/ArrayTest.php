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

    protected function getDummy3()
    {
        $dummy = array(
            'Angela' => array(
                'position' => 'dean',
                'sex'      => 'female',
            ),
            'Bob' => array(
                'position' => 'janitor',
                'sex'      => 'male',
            ),
            'Mark' => array(
                'position' => 'teacher',
                'sex'      => 'male',
                'tenured'  => true,
            ),
            'Wendy' => array(
                'position' => 'teacher',
                'sex'      => 'female',
                'tenured'  => 1,
            ),
        );

        return $dummy;
    }

    public function testToArray()
    {
        $value = Underscore::from($this->getDummy())->toArray();
        $this->assertSame($this->getDummy(), $value);
    }

    public function testTimes()
    {
        $value = Underscore::times(4, function ($count) {
            return pow($count, 3); // cube
        });

        $this->assertInstanceOf('Underscore\Underscore', $value);
        $this->assertAttributeInstanceOf('Underscore\Collection', 'wrapped', $value);

        $this->assertSame(array(0, 1, 8, 27), $value->toArray());
        $this->assertSame(array(0, 1, 8, 27), $value->value());
    }
}
