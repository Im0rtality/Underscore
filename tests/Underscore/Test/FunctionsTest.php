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

    public function testWrap()
    {
        $hello = function ($name) {
            return "hello: $name";
        };

        $moe = Functions::wrap($hello, function ($func) {
            return 'before, ' . $func('moe') . ', after';
        });

        $this->assertEquals('before, hello: moe, after', $moe());

        $anon = Functions::wrap($hello, function ($func, $name) {
            return 'before, ' . $func($name) . ', after';
        });

        $this->assertEquals('before, hello: sue, after', $anon('sue'));
    }
}
