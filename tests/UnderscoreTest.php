<?php

namespace Underscore\Test;

use Underscore\Collection;
use Underscore\Underscore;

class UnderscoreTest extends \PHPUnit_Framework_TestCase
{
    protected function getDummy()
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
    protected function getDummy2()
    {
        $dummy = $this->getDummy();
        $dummy->false = false;
        $dummy->null = null;
        $dummy->zero = 0;

        return $dummy;
    }

    protected function getDummy3()
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
     * @return array
     */
    public function getTestRangeData()
    {
        $out = [];
        // case #0
        $out[] = [0, 4, 1, [0, 1, 2, 3]];
        // case #1
        $out[] = [1, 5, 1, [1, 2, 3, 4]];
        // case #2
        $out[] = [0, 20, 5, [0, 5, 10, 15]];
        // case #3
        $out[] = [0, 0, 1, []];
        // case #4
        $out[] = [1, 2, 0, [], '\LogicException'];

        return $out;
    }

    public function testRegistry()
    {
        // Get current registry
        $registry = Underscore::getRegistry();

        $this->assertInstanceOf('Underscore\Registry', $registry);

        $mocked = $this->getMockBuilder('Underscore\Registry')->getMock();

        Underscore::setRegistry($mocked);

        $this->assertSame($mocked, Underscore::getRegistry());

        // Restore original registry
        Underscore::setRegistry($registry);
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

    public function testCompact()
    {
        $value = Underscore::from($this->getDummy2())
            ->compact()
            ->toArray();

        $this->assertSame(['name' => 'dummy', 'foo' => 'bar', 'baz' => 'qux'], $value);
    }

    public function testClone()
    {
        $original = $this->getDummy();
        $cloned = Underscore::from($original)
            ->clone()
            ->without(['dummy'])
            ->value();

        $this->assertNotEquals(
            Underscore::from($original)->value(),
            $cloned
        );
    }

    public function testSortBy()
    {
        $value = Underscore::from($this->getDummy())
            ->sortBy('strlen')
            ->toArray();

        $this->assertSame(
            [
                'bar',
                'qux',
                'dummy',
            ],
            $value
        );
    }

    /**
     * @return array
     */
    public function getTestFlattenData()
    {
        $out = [];
        // case #0
        $out[] = [
            [1, 2, [3, 4]],
            [1, 2, 3, 4],
        ];

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

        $mock = $this->getMock('stdClass', ['test']);
        $mock->expects($this->once())->method('test')->with((array)$dummy);

        Underscore::from($dummy)->tap([$mock, 'test']);
    }

    public function testThru()
    {
        $dummy = $this->getDummy();

        $mock = $this->getMock('stdClass', ['test']);
        $mock->expects($this->once())->method('test')->with((array)$dummy)->willReturn([123]);

        $this->assertEquals([123], Underscore::from($dummy)->thru([$mock, 'test'])->value());
    }

    /**
     * @expectedException \BadMethodCallException
     */
    public function testCallUnknownMethod()
    {
        Underscore::from([])->foobar();
    }

    /**
     * @return array
     */
    public function getTestUniqData()
    {
        $out = [];
        // case #0
        $out[] = [
            [1, 2, 3, 4, 4, 3],
            [1, 2, 3, 4],
        ];
        // case #1
        $obj1 = new \StdClass;
        $obj2 = new \StdClass;
        $obj3 = $obj1;
        $out[] = [
            [$obj1, $obj1, $obj2, $obj3],
            [$obj1, $obj2],
        ];
        // case #2
        $out[] = [
            [true, false, 1, 0, 0.0, 0.00001],
            [true, false, 1, 0, 0.0, 0.00001],
        ];

        return $out;
    }

    /**
     * @dataProvider getTestUniqData
     */
    public function testUniq($input, $expected)
    {
        $value = Underscore::from($input)
            ->uniq()
            ->toArray();

        $this->assertEquals(array_values($expected), array_values($value));
    }

    public function testExtend()
    {
        $collection = Underscore::from($this->getDummy())
            ->extend([
                'name' => 'extended',
            ]);

        $this->assertSame([
            'name' => 'extended',
            'foo'  => 'bar',
            'baz'  => 'qux',
        ], $collection->toArray());

        $collection = $collection->extend((object)[
            'name' => 'obj',
        ], (object)[
            'name' => 'test',
            'add'  => 'multi'
        ]);

        $this->assertSame([
            'name' => 'test',
            'foo'  => 'bar',
            'baz'  => 'qux',
            'add'  => 'multi'
        ], $collection->toArray());
    }

    public function testDefaults()
    {
        $collection = Underscore::from($this->getDummy())
            ->defaults([
                'name' => 'extended',
            ]);

        $this->assertSame([
            'name' => 'dummy',
            'foo'  => 'bar',
            'baz'  => 'qux',
        ], $collection->toArray());

        $collection = $collection->defaults((object)[
            'bar' => 'gold',
        ], (object)[
            'bar'   => 'silver',
            'color' => 'blue'
        ]);

        $this->assertSame([
            'name'  => 'dummy',
            'foo'   => 'bar',
            'baz'   => 'qux',
            'bar'   => 'gold',
            'color' => 'blue'
        ], $collection->toArray());
    }

    public function testWhere()
    {
        $found = Underscore::from($this->getDummy3())
            ->where([
                'sex' => 'female',
            ])
            ->keys()
            ->toArray();

        $this->assertSame(['Angela', 'Wendy'], $found);

        $found = Underscore::from($this->getDummy3())
            ->where([
                'position' => 'teacher',
            ])
            ->keys()
            ->toArray();

        $this->assertSame(['Mark', 'Wendy'], $found);

        $found = Underscore::from($this->getDummy3())
            ->where([
                'position' => 'teacher',
                'tenured'  => true,
            ])
            ->keys()
            ->toArray();

        $this->assertSame(['Mark'], $found);

        $found = Underscore::from($this->getDummy3())
            ->where([
                'position' => 'teacher',
                'tenured'  => true,
            ], $strict = false)
            ->keys()
            ->toArray();

        $this->assertSame(['Mark', 'Wendy'], $found);

        $found = Underscore::from($this->getDummy3())
            ->where([
                'sex'      => 'female',
                'position' => 'teacher',
            ])
            ->keys()
            ->toArray();

        $this->assertSame(['Wendy'], $found);

        $found = Underscore::from($this->getDummy3())
            ->where([
                'sex'      => 'male',
                'position' => 'dean',
            ])
            ->keys()
            ->toArray();

        $this->assertSame([], $found);
    }

    public function testMixin()
    {
        Underscore::mixin([
            'falsey' => function ($collection) {
                $output = clone $collection;

                foreach ($collection as $k => $v) {
                    if (!empty($v)) {
                        unset($output[$k]);
                    }
                }

                return $output;
            }
        ]);

        $value = Underscore::from($this->getDummy2())
            ->falsey()
            ->toArray();

        $this->assertSame($value, [
            'false' => false,
            'null'  => null,
            'zero'  => 0,
        ]);
        $value = Underscore::from($this->getDummy())
            ->falsey()
            ->toArray();

        $this->assertSame($value, []);
    }
}
