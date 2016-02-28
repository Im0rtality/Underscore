<?php

namespace Underscore\Test;

use Underscore\Functions;

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

    public function testPartial()
    {
        $const = Functions::p();
        $this->assertSame('placeholder for partial', $const());

        $subtract = function ($a, $b) {
            return $b - $a;
        };

        $sub5 = Functions::partial($subtract, 5);

        $this->assertEquals(15, $sub5(20));

        $subFrom20 = Functions::partial($subtract, Functions::p(), 20);

        $this->assertEquals(15, $subFrom20(5));
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

    public function testThrottle()
    {
        $count = 0;

        $ping = Functions::throttle(function () use (&$count) {
            return ++$count;
        }, 100);

        // Creating the throttle calls it once inititally
        $this->assertEquals(1, $count);

        $ping();
        $ping();
        $ping();

        // Should still not be called
        $this->assertEquals(1, $count);

        usleep(100 * 1000); // convert to ms

        $ping();

        $this->assertEquals(2, $count);

        $ping = Functions::throttle(function () use (&$count) {
            return ++$count;
        }, 100, ['leading' => false]);

        // Disabled initial call
        $this->assertEquals(2, $count);

        usleep(100 * 1000); // convert to ms

        $ping();

        $this->assertEquals(3, $count);
    }

    public function testAfter()
    {
        $count = 0;

        $finished = Functions::after(3, function () use (&$count) {
            return ++$count;
        });

        $finished();
        $finished();

        $this->assertEquals(0, $count);

        $finished(); // $count = 1
        $finished(); // $count = 2

        $this->assertEquals(2, $count);
    }

    public function testBefore()
    {
        $salary = 0;

        $askForRaise = function () use (&$salary) {
            return ++$salary;
        };

        $monthlyMeeting = Functions::before(3, $askForRaise);

        $monthlyMeeting();
        $monthlyMeeting(); // $salary = 2
        $monthlyMeeting(); // memoized

        $this->assertEquals(2, $salary);
    }
}
