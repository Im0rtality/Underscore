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
     *
     * @param int $offset
     */
    public function offsetExists($offset)
    {
        return $this->isObject() ? isset($this->wrapped->{$offset}) : isset($this->wrapped[$offset]);
    }

    /**
     * @inheritdoc
     *
     * @param int $offset
     */
    public function offsetGet($offset)
    {
        return $this->isObject() ? $this->wrapped->{$offset} : $this->wrapped[$offset];
    }

    /**
     * @inheritdoc
     *
     * @param int   $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value)
    {
        if (null !== $offset) {
            if ($this->isObject()) {
                $this->wrapped->{$offset} = $value;
            } else {
                $this->wrapped[$offset] = $value;
            }
        } else {
            if ($this->isObject()) {
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
     *
     * @param int $offset
     */
    public function offsetUnset($offset)
    {
        if ($this->isObject()) {
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
        return $this->isObject() ? get_object_vars($this->wrapped) : $this->wrapped;
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
        if ($this->isObject()) {
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

    /**
     * Calls is_object on wrapped object
     *
     * @return bool
     */
    public function isObject()
    {
        return is_object($this->wrapped);
    }
}
