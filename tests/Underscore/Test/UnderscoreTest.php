<?php

namespace Underscore\Test;

use Underscore\Collection;
use Underscore\Underscore;

/**
 * Class MasterTest
 * @package Underscore\Test
 */
abstract class UnderscoreTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @return mixed
     */
    abstract protected function getDummy();

    /**
     * @return mixed
     */
    abstract protected function getDummy2();

    /**
     * @return array
     */
    public function getTestRangeData()
    {
        $out = array();
        // case #0
        $out[] = array(0, 4, 1, array(0, 1, 2, 3));
        // case #1
        $out[] = array(1, 5, 1, array(1, 2, 3, 4));
        // case #2
        $out[] = array(0, 20, 5, array(0, 5, 10, 15));
        // case #3
        $out[] = array(0, 0, 1, array());
        // case #4
        $out[] = array(1, 2, 0, array(), '\LogicException');

        return $out;
    }

    /**
     * @dataProvider getTestRangeData
     */
    public function testRange($start, $stop, $step, $expected, $exception = null)
    {
        $exception && $this->setExpectedException($exception);

        $this->assertEquals(
            $expected,
            Underscore::range($start, $stop, $step)->toArray()
        );
    }

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

    public function testPick()
    {
        $value = Underscore::from(array($this->getDummy(), $this->getDummy(), $this->getDummy()))
            ->pick('foo')
            ->toArray();

        $this->assertSame(array('bar', 'bar', 'bar'), $value);
    }

    public function testPickGetter()
    {
        $value = Underscore::from(array(new Dummy()))
            ->pick('getFoo')
            ->toArray();

        $this->assertSame(array('foo'), $value);
    }

    public function testContains()
    {
        $this->assertTrue(Underscore::from($this->getDummy())->contains('bar')->value());
        $this->assertFalse(Underscore::from($this->getDummy())->contains('baz')->value());
    }

    public function testFind()
    {
        $iterator = function ($needle) {
            return function ($value) use ($needle) {
                return $value === $needle;
            };
        };
        $this->assertTrue(Underscore::from($this->getDummy())->find($iterator('bar'))->value());
        $this->assertFalse(Underscore::from($this->getDummy())->find($iterator('foo'))->value());
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

        $this->assertSame(array('name' => 'dummy'), $value);
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

        $this->assertSame(array('foo' => 'bar', 'baz' => 'qux'), $value);
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

    public function testSize()
    {
        $value = Underscore::from($this->getDummy())
            ->size();

        $this->assertSame(3, $value);
    }

    public function testHead()
    {
        $value = Underscore::from($this->getDummy())
            ->head(2)
            ->value();

        $this->assertSame(array('name' => 'dummy', 'foo' => 'bar'), $value);
    }

    public function testTail()
    {
        $value = Underscore::from($this->getDummy())
            ->tail(1)
            ->value();

        $this->assertSame(array('foo' => 'bar', 'baz' => 'qux'), $value);
    }

    public function testInitial()
    {
        $value = Underscore::from($this->getDummy())
            ->initial(2)
            ->value();

        $this->assertSame(array('name' => 'dummy'), $value);
    }

    public function testLast()
    {
        $value = Underscore::from($this->getDummy())
            ->last(2)
            ->value();

        $this->assertSame(array('foo' => 'bar', 'baz' => 'qux'), $value);
    }

    public function testCompact()
    {
        $value = Underscore::from($this->getDummy2())
            ->compact()
            ->toArray();

        $this->assertSame(array('name' => 'dummy', 'foo' => 'bar', 'baz' => 'qux'), $value);
    }

    public function testWithout()
    {
        $value = Underscore::from($this->getDummy())
            ->without(array('dummy'))
            ->toArray();

        $this->assertSame(array('foo' => 'bar', 'baz' => 'qux'), $value);
    }

    public function testMerge()
    {
        $value = Underscore::from($this->getDummy())
            ->merge(new Collection($this->getDummy2()))
            ->toArray();

        $this->assertSame(
            array(
                'name'  => 'dummy',
                'foo'   => 'bar',
                'baz'   => 'qux',
                'false' => false,
                'null'  => null,
                'zero'  => 0,
            ),
            $value
        );
    }

    public function testValues()
    {
        $value = Underscore::from($this->getDummy())
            ->values()
            ->toArray();

        $this->assertSame(
            array(
                'dummy',
                'bar',
                'qux',
            ),
            $value
        );
    }

    public function testKeys()
    {
        $value = Underscore::from($this->getDummy())
            ->keys()
            ->toArray();

        $this->assertSame(
            array(
                'name',
                'foo',
                'baz',
            ),
            $value
        );
    }

    public function testClone()
    {
        $original = $this->getDummy();
        $cloned   = Underscore::from($original)
            ->clone()
            ->without(array('dummy'))
            ->value();

        $this->assertNotEquals(
            Underscore::from($original)->value(),
            $cloned
        );
    }

    public function testZip()
    {
        $value = Underscore::from($this->getDummy())
            ->zip(array('a', 1, '42'))
            ->toArray();

        $this->assertSame(
            array(
                'a'  => 'dummy',
                1    => 'bar',
                '42' => 'qux',
            ),
            $value
        );

        $this->setExpectedException('\LogicException');
        Underscore::from($this->getDummy())
            ->zip(array('a'));
    }

    public function testGroupBy()
    {
        $value = Underscore::from($this->getDummy())
            ->groupBy('strlen')
            ->toArray();

        $this->assertSame(
            array(
                5 => array('dummy'),
                3 => array('bar', 'qux'),
            ),
            $value
        );
    }

    public function testSortBy()
    {
        $value = Underscore::from($this->getDummy())
            ->sortBy('strlen')
            ->toArray();

        $this->assertSame(
            array(
                'bar',
                'qux',
                'dummy',
            ),
            $value
        );
    }

    /**
     * @return array
     */
    public function getTestFlattenData()
    {
        $out = array();
        // case #0
        $out[] = array(
            array(1, 2, array(3, 4)),
            array(1, 2, 3, 4),
        );
        return $out;
    }

    /**
     * @dataProvider getTestFlattenData
     */
    public function testFlatten($input, $expected)
    {
        $value = Underscore::from($input)
            ->flatten()
            ->toArray();

        $this->assertSame($expected, $value);
    }

    public function testTap()
    {
        $dummy = $this->getDummy();

        $mock = $this->getMock('stdClass', array('test'));
        $mock->expects($this->once())->method('test')->with($dummy);

        Underscore::from($dummy)->tap(array($mock, 'test'));
    }

    /**
     * @expectedException \BadMethodCallException
     */
    public function testCallUnknownMethod()
    {
        Underscore::from(array())->foobar();
    }

    public function testDefaults()
    {
        $collection = Underscore::from($this->getDummy())
            ->defaults(array(
                'name' => 'extended',
            ));

        $this->assertSame(array(
            'name' => 'dummy',
            'foo'  => 'bar',
            'baz'  => 'qux',
        ), $collection->toArray());

        $collection = $collection->defaults((object) array(
            'bar'   => 'gold',
        ), (object) array(
            'bar'   => 'silver',
            'color' => 'blue'
        ));

        $this->assertSame(array(
            'name'  => 'dummy',
            'foo'   => 'bar',
            'baz'   => 'qux',
            'bar'   => 'gold',
            'color' => 'blue'
        ), $collection->toArray());
    }
}
