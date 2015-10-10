<?php

namespace Underscore\Test;

use Underscore\Collection;

class CollectionTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @return array
     */
    public function getTestCollectionData()
    {
        $dummy = new Dummy();
        $data  = array();
        // case #0
        $data[] = array($dummy);
        // case #1
        $data[] = array(get_object_vars($dummy));

        return $data;
    }

    /**
     * @dataProvider getTestCollectionData
     */
    public function testCollection($item)
    {
        $collection = new Collection($item);

        // count
        $this->assertSame(2, $collection->count());
        // ArrayAccess test

        // isset
        $this->assertTrue(isset($collection['name']));
        $this->assertFalse(isset($collection['precious']));
        $this->assertFalse(isset($collection['foo']));
        // get
        $this->assertSame('dummy', $collection['name']);
        $this->assertSame(42, $collection['answer']);
        // set
        $collection['foo'] = 'bar';
        $this->assertTrue(isset($collection['foo']));
        $this->assertSame('bar', $collection['foo']);
        $this->assertSame(3, $collection->count());
        // unset
        unset($collection['foo']);
        $this->assertFalse(isset($collection['foo']));
        $this->assertSame(2, $collection->count());

        // Iterator test
        $this->assertInstanceOf('\Traversable', $collection->getIterator());

        $out = array();
        foreach ($collection as $key => $value) {
            $out[$key] = $value;
        }
        $this->assertSame(array('name' => 'dummy', 'answer' => 42), $out);

        // Reversed iterator test
        $this->assertInstanceOf('\Traversable', $collection->getIteratorReversed());

        $out = array();
        foreach ($collection->getIteratorReversed() as $key => $value) {
            $out[$key] = $value;
        }
        $this->assertSame(array('answer' => 42, 'name' => 'dummy'), $out);

        // toArray & value
        $this->assertSame(array('name' => 'dummy', 'answer' => 42), $collection->toArray());
        $this->assertSame($collection->toArray(), $collection->value());

        $collection['foo'] = 'baz';
        // here we have one extra key-value pair
        $this->assertSame(array('name' => 'dummy', 'answer' => 42, 'foo' => 'baz'), $collection->toArray());

        // collection wrapping
        $wrapped = new Collection($collection);
        $this->assertSame($collection->toArray(), $wrapped->toArray());
    }

    /**
     * @dataProvider getTestCollectionData
     */
    public function testSetValueOnNullKey($item)
    {
        $collection = new Collection($item);
        /** @var $collection Collection */

        $this->assertEquals(2, $collection->count());

        $collection[] = 'foo';
        $this->assertEquals(3, $collection->count());

        // test finding next free numeric key
        $collection[] = 'foo';
        $this->assertEquals(4, $collection->count());
    }

    /**
     * @return array
     */
    public function getTestCloneData()
    {
        $json = '{"foo":"bar", "baz":"qux"}';
        $out  = array();
        // case #0
        $out[] = array(
            json_decode($json, true),
        );

        return $out;
    }

    /**
     * @dataProvider getTestCloneData
     */
    public function testClone($clonee)
    {
        $result = new Collection($clonee);

        $clone = clone $result;

        $value = $clone->value();

        $this->assertEquals($clonee, $value);
    }
}
