<?php

namespace Underscore\Test\Mutator;

use Underscore\Mutator;

abstract class BaseMutatorTest extends \PHPUnit_Framework_TestCase
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
     * @return object
     */
    protected static function getDummy4()
    {
        $dummy = self::getDummy2();
        $dummy->false = false;
        $dummy->null = null;
        $dummy->zero = 0;
        $dummy->one = 1;

        return $dummy;
    }
    /**
     * @return Mutator|callable
     */
    abstract protected function getInstance();

    /**
     * @return mixed[]
     */
    abstract public function getTestInvokeData();

    /**
     * @param mixed $expected
     * @param mixed $args
     * @dataProvider getTestInvokeData
     */
    public function testInvoke($expected, $args)
    {
        $this->assertSame($expected, call_user_func_array($this->getInstance(), $args)->toArray());
    }
}
