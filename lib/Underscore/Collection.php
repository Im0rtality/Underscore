<?php

namespace Underscore;

/**
 * Class Collection
 * @package Underscore
 */
class Collection implements \ArrayAccess, \IteratorAggregate
{
    /** @var  mixed */
    protected $wrapped;

    /**
     * @param Object|array $object
     */
    public function __construct($object)
    {
        $this->wrapped = $object;
    }

    /**
     * @inheritdoc
     */
    public function offsetExists($offset)
    {
        return is_object($this->wrapped) ? isset($this->wrapped->{$offset}) : isset($this->wrapped[$offset]);
    }

    /**
     * @inheritdoc
     */
    public function offsetGet($offset)
    {
        return is_object($this->wrapped) ? $this->wrapped->{$offset} : $this->wrapped[$offset];
    }

    /**
     * @inheritdoc
     */
    public function offsetSet($offset, $value)
    {
        if (null !== $offset) {
            if (is_object($this->wrapped)) {
                $this->wrapped->{$offset} = $value;
            } else {
                $this->wrapped[$offset] = $value;
            }
        } else {
            if (is_object($this->wrapped)) {
                $offset = 0;
                while ($this->offsetExists($offset)) {
                    $offset++;
                }
                $this->wrapped->{$offset} = $value;
            } else {
                $this->wrapped[] = $value;
            }
        }
    }

    /**
     * @inheritdoc
     */
    public function offsetUnset($offset)
    {
        if (is_object($this->wrapped)) {
            unset($this->wrapped->{$offset});
        } else {
            unset($this->wrapped[$offset]);
        }
    }

    /**
     * @return mixed
     */
    public function value()
    {
        return $this->wrapped;
    }

    /**
     * @return mixed[]
     */
    public function toArray()
    {
        return is_object($this->wrapped) ? get_object_vars($this->wrapped) : $this->wrapped;
    }

    /**
     * @inheritDoc
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->toArray());
    }

    /**
     * Returns reversed iterator. See getIterator() for docs.
     */
    public function getIteratorReversed()
    {
        return new \ArrayIterator(array_reverse($this->toArray(), true));
    }

    /**
     * Gets the size of the collection by returning length for arrays or number of enumerable properties for objects.
     * @return int
     */
    public function count()
    {
        return count($this->toArray());
    }

    public function __clone()
    {
        if (is_object($this->wrapped)) {
            $this->wrapped = clone $this->wrapped;
        } else {
            $this->wrapped = array_map(
                function ($item) {
                    return $item;
                },
                $this->wrapped
            );
        }

    }
}
