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
 * @method Underscore sortBy(callable $iterator)
 * @method Underscore tap(callable $iterator)
 * @method Underscore contains(mixed $needle)
 * @method Underscore compact()
 * @method Underscore values()
 * @method Underscore keys()
 * @method Underscore flatten()
 * @method Underscore head(int $count = 1)
 * @method Underscore tail(int $count = 1)
 * @method Underscore initial(int $count = 1)
 * @method Underscore last(int $count = 1)
 * @method Underscore zip(array $keys)
 * @method Underscore merge($values)
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
     * Clones makes clone of collection
     *
     * @return Underscore
     */
    public function clon()
    {
        return self::from(unserialize(serialize($this->wrapped->value())));
    }
}
