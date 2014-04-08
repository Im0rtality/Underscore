<?php

namespace Underscore;

/**
 * Class Underscore
 * @package Underscore
 *
 * @method Underscore invoke(callable $iterator)
 * @method Underscore reduce(callable $iterator, mixed $initial = null)
 * @method Underscore reduceRight(callable $iterator, mixed $initial = null)
 * @method Underscore map(callable $iterator)
 * @method Underscore pick(mixed $key)
 * @method Underscore all(callable $iterator)
 * @method Underscore any(callable $iterator)
 * @method Underscore filter(callable $iterator)
 * @method Underscore reject(callable $iterator)
 * @method Underscore find(callable $iterator)
 * @method Underscore groupBy(callable $iterator)
 * @method Underscore contains(mixed $needle)
 * @method Underscore compact()
 * @method Underscore values()
 * @method Underscore keys()
 * @method Underscore flatten()
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
