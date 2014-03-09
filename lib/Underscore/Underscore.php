<?php

namespace Underscore;

/**
 * Class Underscore
 * @package Underscore
 */
class Underscore
{
    /** @var  Collection */
    protected $wrapped;

    /**
     * Initializes Underscore object and sets argument as internal collection
     *
     * @param mixed $item
     * @return Underscore
     */
    public static function from($item)
    {
        $underscore = new Underscore();

        $underscore->wrapped = new Collection($item);

        return $underscore;
    }

    /**
     * Returns object
     *
     * @return mixed
     */
    public function value()
    {
        if ($this->wrapped instanceof Collection) {
            return $this->wrapped->value();
        } else {
            return $this->wrapped;
        }
    }

    /**
     * Returns object as array
     *
     * @return mixed[]
     */
    public function toArray()
    {
        return $this->wrapped->toArray();
    }

    /**
     * Call $iterator for each element
     *
     * $iterator = function($value, $key, $collection)
     *
     * @param \Closure $iterator
     * @return Underscore
     */
    public function invoke($iterator)
    {
        foreach ($this->wrapped as $k => $v) {
            call_user_func($iterator, $v, $k, $this->wrapped);
        }

        return $this;
    }

    /**
     * Replaces every element with value returned by individual $iterator call
     *
     * $iterator = function($value, $key, $collection)
     *
     * @param \Closure $iterator
     * @return Underscore
     */
    public function map($iterator)
    {
        $collection = clone $this->wrapped;

        foreach ($collection as $k => $v) {
            $collection[$k] = call_user_func($iterator, $v, $k, $collection);
        }

        $this->wrapped = $collection;

        return $this;
    }

    /**
     * Reduces collection to single value using $iterator
     *
     * $iterator = function($accumulator, $value)
     *
     * @param \Closure $iterator
     * @param mixed    $initial
     * @return Underscore
     */
    public function reduce($iterator, $initial = null)
    {
        $collection = clone $this->wrapped;

        foreach ($collection as $value) {
            $initial = call_user_func($iterator, $initial, $value);
        }

        $this->wrapped = $initial;

        return $this;
    }

    /**
     * Reduces collection to single value using $iterator. Reversed direction.
     *
     * $iterator = function($accumulator, $value)
     *
     * @param \Closure $iterator
     * @param mixed    $initial
     * @return Underscore
     */
    public function reduceRight($iterator, $initial = null)
    {
        $collection = clone $this->wrapped;

        foreach ($collection->getIteratorReversed() as $value) {
            $initial = call_user_func($iterator, $initial, $value);
        }

        $this->wrapped = $initial;

        return $this;
    }

    /**
     * Serves as shorthand to get list of specific key value from every element
     *
     * If key not found returns null
     *
     * @param mixed $key
     * @return Underscore
     */
    public function pluck($key)
    {
        return $this->map(
            function ($value) use ($key) {
                if (is_object($value)) {
                    return isset($value->{$key}) ? $value->{$key} : null;
                } else {
                    return isset($value[$key]) ? $value[$key] : null;
                }
            }
        );
    }

    /**
     * Checks if a given value is present in a collection using strict equality for comparisons.
     *
     * Returns bool
     *
     * @param mixed $needle
     * @return Underscore
     */
    public function contains($needle)
    {
        $collection = clone $this->wrapped;

        $found = false;
        foreach ($collection as $value) {
            if ($value === $needle) {
                $found = true;
                break;
            }
        }
        $this->wrapped = $found;

        return $this;
    }

    /**
     * Iterates over elements of a collection, returning an array of all elements the callback returns truey for.
     *
     * @param \Closure $iterator
     * @return Underscore
     */
    public function filter($iterator)
    {
        $collection = clone $this->wrapped;

        foreach ($this->wrapped as $k => $v) {
            if (!call_user_func($iterator, $v, $k)) {
                unset($collection[$k]);
            }
        }

        $this->wrapped = $collection;

        return $this;
    }

    /**
     * Checks if the $iterator returns a truey value for ANY element of a collection.
     * The function returns as soon as it finds a passing value and does not iterate
     * over entire collection.
     *
     * Returns boolean
     *
     * @param \Closure $iterator
     * @return Underscore
     */
    public function any($iterator)
    {
        $collection = clone $this->wrapped;

        $found = false;
        foreach ($collection as $k => $v) {
            if (call_user_func($iterator, $v, $k)) {
                $found = true;
                break;
            }
        }

        $this->wrapped = $found;

        return $this;
    }

    /**
     * Checks if the $iterator returns a truey value for ALL element of a collection.
     *
     * Returns boolean
     *
     * @param \Closure $iterator
     * @return Underscore
     */
    public function all($iterator)
    {
        $this->reduce(
            function ($accumulator, $item) use ($iterator) {
                $accumulator = $accumulator && $iterator($item);
                return $accumulator;
            },
            true
        );

        return $this;
    }
}
