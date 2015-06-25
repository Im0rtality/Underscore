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

    public function testCompose()
    {
        $greet = function ($name) {
            return "hi: $name";
        };

        $exclaim = function ($statement) {
            return strtoupper($statement) . '!';
        };

        $welcome = Functions::compose($greet, $exclaim);

        $this->assertEquals('hi: MOE!', $welcome('moe'));
    }
}
