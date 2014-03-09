<?php

namespace Underscore\Test;

use Underscore\Underscore;

/**
 * Class MasterTest
 * @package Underscore\Test
 */
abstract class MasterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @return mixed
     */
    abstract protected function getDummy();

    public function testValue()
    {
        $value = Underscore::from($this->getDummy())->value();
        $this->assertEquals($this->getDummy(), $value);
    }

    public function testInvoke()
    {
        $buffer = '';
        Underscore::from($this->getDummy())
            ->invoke(
                function ($value, $key) use (&$buffer) {
                    $buffer .= sprintf('%s:%s|', $key, $value);
                }
            );
        $this->assertSame('name:dummy|foo:bar|baz:qux|', $buffer);
    }

    public function testMap()
    {
        $value = Underscore::from($this->getDummy())
            ->map(
                function ($value, $key) use (&$buffer) {
                    return sprintf('%s:%s', $key, $value);
                }
            )->toArray();

        $this->assertSame(
            array('name' => 'name:dummy', 'foo' => 'foo:bar', 'baz' => 'baz:qux'),
            $value
        );
    }

    public function testReduce()
    {
        $value = Underscore::from($this->getDummy())
            ->reduce(
                function ($accu, $value) {
                    $accu .= $value . ' ';
                    return $accu;
                },
                ''
            )->value();

        $this->assertSame('dummy bar qux ', $value);
    }

    public function testReduceRight()
    {
        $value = Underscore::from($this->getDummy())
            ->reduceRight(
                function ($accumulator, $value) {
                    $accumulator .= $value . ' ';
                    return $accumulator;
                },
                ''
            )->value();

        $this->assertSame('qux bar dummy ', $value);
    }

    public function testPluck()
    {
        $value = Underscore::from(array($this->getDummy(), $this->getDummy(), $this->getDummy()))
            ->pluck('foo')
            ->toArray();

        $this->assertSame(array('bar', 'bar', 'bar'), $value);
    }

    public function testContains()
    {
        $this->assertTrue(Underscore::from($this->getDummy())->contains('foo')->value());
        $this->assertFalse(Underscore::from($this->getDummy())->contains('bar')->value());
    }

    public function testFind()
    {
        $iterator = function ($needle) {
            return function ($value) use ($needle) {
                return $value === $needle;
            };
        };
        $this->assertTrue(Underscore::from($this->getDummy())->find($iterator('foo'))->value());
        $this->assertFalse(Underscore::from($this->getDummy())->find($iterator('bar'))->value());
    }

    public function testFilter()
    {
        $value = Underscore::from($this->getDummy())
            ->filter(
                function ($value) {
                    return 3 < strlen($value);
                }
            )
            ->toArray();

        $this->assertSame(array('foo' => 'bar', 'baz' => 'qux'), $value);
    }

    public function testReject()
    {
        $value = Underscore::from($this->getDummy())
            ->reject(
                function ($value) {
                    return 3 < strlen($value);
                }
            )
            ->toArray();

        $this->assertSame(array('name' => 'dummy'), $value);
    }

    public function testAny()
    {
        $value = Underscore::from($this->getDummy())
            ->any(
                function ($value) {
                    return 3 < strlen($value);
                }
            )
            ->value();

        $this->assertSame(true, $value);

        $value = Underscore::from($this->getDummy())
            ->any(
                function ($value) {
                    return strlen($value) < 2;
                }
            )
            ->value();

        $this->assertSame(false, $value);
    }

    public function testAll()
    {
        $value = Underscore::from($this->getDummy())
            ->all(
                function ($value) {
                    return 3 <= strlen($value);
                }
            )
            ->value();

        $this->assertSame(true, $value);

        $value = Underscore::from($this->getDummy())
            ->all(
                function ($value) {
                    return 3 < strlen($value);
                }
            )
            ->value();

        $this->assertSame(false, $value);
    }
}
