<?php

namespace Underscore\Test;

use Underscore\Functions;

/**
 * Class FunctionsTest
 * @package Underscore\Test
 */
class FunctionsTest extends \PHPUnit_Framework_TestCase
{
    public function testMemoize()
    {
        $counter = 0;

        $payload = function () use (&$counter) {
            ++$counter;
        };

        $memoized = Functions::memoize($payload);

        $memoized();
        $memoized();
        $memoized();
        $memoized();
        $memoized();

        $this->assertEquals(1, $counter);
    }

    public function testNop()
    {
        $nop = Functions::nop();

        $ref = new \stdClass();

        $this->assertSame($ref, $nop($ref));
    }

    public function testPartial()
    {
        $subtract = function ($a, $b) {
            return $b - $a;
        };

        $sub5 = Functions::partial($subtract, 5);

        $this->assertEquals(15, $sub5(20));

        $subFrom20 = Functions::partial($subtract, Functions::p(), 20);

        $this->assertEquals(15, $subFrom20(5));
    }
}
