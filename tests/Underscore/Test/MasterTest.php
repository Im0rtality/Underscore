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

    public function testToArray()
    {
        $value = Underscore::from($this->getDummy())->toArray();
        $this->assertSame(get_object_vars($this->getDummy()), $value);
    }

    public function testEach()
    {
        $buffer = '';
        Underscore::from($this->getDummy())
            ->each(
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
        $this->assertFalse(Underscore::from($this->getDummy())->contains('foo')->value());
        $this->assertTrue(Underscore::from($this->getDummy())->contains('bar')->value());
    }
}
