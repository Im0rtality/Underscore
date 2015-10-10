<?php

namespace Underscore\Test\Accessor;

use Underscore\Accessor;
use Underscore\Collection;

abstract class BaseAccessorTest extends \PHPUnit_Framework_TestCase
{
    protected static function getDummy1()
    {
        $dummy = new \stdClass();
        $dummy->name = 'dummy';
        $dummy->foo = 'bar';
        $dummy->baz = 'qux';

        return $dummy;
    }

    /**
     * @return object
     */
    protected static function getDummy2()
    {
        $dummy = self::getDummy1();
        $dummy->false = false;
        $dummy->null = null;
        $dummy->zero = 0;

        return $dummy;
    }

    protected static function getDummy3()
    {
        $dummy = [
            'Angela' => [
                'position' => 'dean',
                'sex'      => 'female',
            ],
            'Bob'    => [
                'position' => 'janitor',
                'sex'      => 'male',
            ],
            'Mark'   => [
                'position' => 'teacher',
                'sex'      => 'male',
                'tenured'  => true,
            ],
            'Wendy'  => [
                'position' => 'teacher',
                'sex'      => 'female',
                'tenured'  => 1,
            ],
        ];

        return $dummy;
    }

    /**
     * @return Accessor
     */
    abstract protected function getInstance();

    /**
     * @return mixed[]
     */
    abstract protected function getTestInvokeData();

    /**
     * @param mixed $data
     * @param mixed $expected
     * @dataProvider getTestInvokeData
     */
    public function testInvoke($data, $expected)
    {
        $this->assertSame($expected, $this->getInstance()->__invoke(new Collection($data)));
    }
}
