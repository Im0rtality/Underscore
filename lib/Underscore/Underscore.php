<?php

namespace Underscore;

/**
 * Class Underscore
 * @package Underscore
 * @SuppressWarnings(TooManyMethods) - these methods belong here
 * @method Underscore invoke(callable $iterator)
 * @method Underscore reduce(callable $iterator, mixed $initial = null)
 * @method Underscore reduceRight(callable $iterator, mixed $initial = null)
 * @method Underscore map(callable $iterator)
 * @method Underscore all(callable $iterator)
 * @method Underscore any(callable $iterator)
 * @method Underscore filter(callable $iterator)
 * @method Underscore reject(callable $iterator)
 * @method Underscore compact()
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

        $underscore->wrap($item);

        return $underscore;
    }

    /**
     * Creates Underscore object containing array of numbers
     *
     * @param int $start Start number, inclusive
     * @param int $stop  Stop number, not inclusive
     * @param int $step  Step size, non-zero, can be negative
     *
     * @throws \LogicException
     * @return Underscore
     */
    public static function range($start, $stop, $step = 1)
    {
        if (0 == $step) {
            throw new \LogicException('$step have to be non-zero');
        }

        $array      = array();
        $underscore = new Underscore();

        for ($i = (int)$start; $i < (int)$stop; $i += (int)$step) {
            $array[] = $i;
        }

        $underscore->wrap($array);

        return $underscore;
    }

    /**
     * @param mixed $item
     */
    protected function wrap($item)
    {
        $this->wrapped = new Collection($item);
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
     * @param string $method
     * @param array  $args
     * @return $this
     */
    public function __call($method, $args)
    {
        $payloadClass = sprintf('\Underscore\Method\%sMethod', ucfirst($method));
        /** @var $payload callable */
        $payload = new $payloadClass();

        array_unshift($args, $this->wrapped);
        $this->wrapped = call_user_func_array($payload, $args);

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
    public function pick($key)
    {
        return $this->map(
            function ($value) use ($key) {
                if (is_object($value)) {
                    if (is_callable(array($value, $key))) {
                        return call_user_func(array($value, $key));
                    } else {
                        return isset($value->{$key}) ? $value->{$key} : null;
                    }
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
        $finder = function ($needle) {
            return function ($value) use ($needle) {
                return $value === $needle;
            };
        };

        $this->find($finder($needle));

        return $this;
    }

    /**
     * Iterates over elements of a collection, returning the first element that the callback returns truey for.
     *
     * Returns mixed
     *
     * @param callable $iterator
     * @return Underscore
     */
    public function find($iterator)
    {
        $collection = clone $this->wrapped;

        $found = false;
        foreach ($collection as $k => $v) {
            if (call_user_func($iterator, $k, $v, $collection)) {
                $found = true;
                break;
            }
        }
        $this->wrapped = $found;

        return $this;
    }

    /**
     * Gets the size of the collection by returning length for arrays or number of enumerable properties for objects.
     *
     * Returns int
     *
     * @return Underscore
     */
    public function size()
    {
        return $this->wrapped->count();
    }

    /**
     * Gets the first element or first n elements of collection.
     *
     * Returns mixed[]
     *
     * @param int $count
     *
     * @return Underscore
     */
    public function head($count = 1)
    {
        $this->wrapped = array_slice($this->wrapped->toArray(), 0, $count);

        return $this;
    }

    /**
     * Gets the last element or last n elements of collection.
     *
     * Returns mixed[]
     *
     * @param int $count
     *
     * @return Underscore
     */
    public function last($count = 1)
    {
        $this->wrapped = array_slice($this->wrapped->toArray(), -$count);

        return $this;
    }

    /**
     * Gets all but the first element or first n elements of collection.
     *
     * Returns mixed[]
     *
     * @param int $count
     *
     * @return Underscore
     */
    public function tail($count = 1)
    {
        $this->wrapped = array_slice($this->wrapped->toArray(), $count);

        return $this;
    }

    /**
     * Gets all but the last element or last n elements of collection.
     *
     * Returns mixed[]
     *
     * @param int $count
     *
     * @return Underscore
     */
    public function initial($count = 1)
    {
        $this->wrapped = array_slice($this->wrapped->toArray(), 0, -$count);

        return $this;
    }

    /**
     * Removes all provided values using strict comparison.
     *
     * @param mixed[] $values
     *
     * @return Underscore
     */
    public function without($values = array())
    {
        $this->reject(
            function ($item) use ($values) {
                return in_array($item, $values, true);
            }
        );
        return $this;
    }

    /**
     * Merges two collections. If keys collide, new value overwrites older.
     *
     * @param Underscore $values
     *
     * @return Underscore
     */
    public function merge(Underscore $values)
    {
        foreach ($values->wrapped as $key => $value) {
            $this->wrapped[$key] = $value;
        }

        return $this;
    }

    /**
     * Creates an collection composed of the enumerable property values of object.
     *
     * @return Underscore
     */
    public function values()
    {
        $collection = array();

        foreach ($this->wrapped as $value) {
            $collection[] = $value;
        }

        $this->wrapped = self::from($collection);

        return $this;
    }

    /**
     * Creates an collection composed of the enumerable property keys of object.
     *
     * @return Underscore
     * @SuppressWarnings(UnusedLocalVariable) - $value in foreach
     */
    public function keys()
    {
        $collection = array();

        foreach ($this->wrapped as $key => $value) {
            $collection[] = $key;
        }

        $this->wrap($collection);

        return $this;
    }

    /**
     * Clones makes clone of collection
     *
     * @return Underscore
     */
    public function clon()
    {
        return self::from(unserialize(serialize($this->wrapped->value())));
    }

    /**
     * Combines current collection values with given keys to produce new collection
     *
     * @param mixed[] $keys
     *
     * @throws \LogicException
     * @return Underscore
     */
    public function zip($keys)
    {
        $values = $this->values()->toArray();
        $keys = self::from($keys)->values()->toArray();

        if (count($values) !== count($keys)) {
            throw new \LogicException('Keys and values count must match');
        }

        $collection = array();
        foreach ($values as $index => $value) {
            $collection[$keys[$index]] = $value;
        }

        $this->wrap($collection);

        return $this;
    }

    /**
     * Creates an object composed of keys generated from the results
     * of running each element of a collection through the callback
     *
     * @param callable $callback
     *
     * @return Underscore
     */
    public function groupBy($callback)
    {
        $collection = clone $this->wrapped;

        $result = array();
        foreach ($collection as $value) {
            $key            = call_user_func($callback, $value);
            $result[$key][] = $value;
        }

        $this->wrap($result);

        return $this;
    }

    /**
     * Creates an array of elements, sorted in ascending order by the results
     * of running each element in a collection through the callback
     *
     * When values returned by $callback are equal the order is undefined
     * i.e. the sorting is not stable
     *
     * @param callable $callback
     *
     * @return Underscore
     */
    public function sortBy($callback)
    {
        $sort = function ($value) {
            sort($value);
            return $value;
        };

        $collection = clone $this->groupBy($callback);
        $collection = $collection->value();
        $this
            ->keys()
            ->tap($sort)
            ->map(
                function ($key) use ($collection) {
                    return $collection[$key];
                }
            )
            ->flatten();

        return $this;
    }

    /**
     * Performs shallow flatten operation on collection (unwraps first level of array)
     *
     * @return Underscore
     */
    public function flatten()
    {
        $result = array();
        foreach ($this->wrapped as $value) {
            $result = array_merge($result, is_array($value) ? $value : array($value));
        }

        $this->wrap($result);

        return $this;
    }

    /**
     * Invokes $callback with the wrapped value of collection as the first argument
     * and then wraps it back.
     *
     * The purpose of this method is to "tap into" a method chain in order to
     * perform operations on intermediate results within the chain.
     *
     * @param callable $callback
     *
     * @return Underscore
     */
    public function tap($callback)
    {
        $raw = $this->wrapped->value();

        $raw = call_user_func($callback, $raw);

        $this->wrap($raw);

        return $this;
    }
}
