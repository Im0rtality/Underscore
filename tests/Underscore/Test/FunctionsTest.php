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

    public function testOnce()
    {
        $counter = 0;

        $initialize = Functions::once(function () use (&$counter) {
            return ++$counter;
        });

        $this->assertEquals(0, $counter);

        $initialize(); // $counter = 1

        $this->assertEquals(1, $initialize());

        $another = Functions::once(function () use (&$counter) {
            return ++$counter;
        });

        $another(); // $counter = 2

        $this->assertEquals(2, $another());
    }
}
