<?php

namespace Underscore\Test\Accessor;

use Underscore\Accessor;

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
     * @return Accessor|callable
     */
    abstract protected function getInstance();

    /**
     * @return mixed[]
     */
    abstract protected function getTestInvokeData();

    /**
     * @param mixed $expected
     * @param mixed $args
     * @dataProvider getTestInvokeData
     */
    public function testInvoke($expected, $args)
    {
        $this->assertSame($expected, call_user_func_array($this->getInstance(), $args));
    }
}
