<?php

namespace Underscore;

/**
 * Class Underscore
 * @package Underscore
 */
class Underscore
{
    protected $wrapped;

    public static function from($item)
    {
        $underscore           = new Underscore();
        $underscore->wrapped = $item;

        return $underscore;
    }

    // End the chain
    public function value()
    {
        return $this->wrapped;
    }

    // Invoke the iterator on each item in the collection
    public function each($iterator)
    {
        foreach ($this->wrapped as $k => $v) {
            call_user_func($iterator, $v, $k, $this->wrapped);
        }

        return $this;
    }

    public function map($iterator)
    {
        $collection = clone $this->wrapped;

        $return = [];
        foreach ($collection as $k => $v) {
            $return[] = call_user_func($iterator, $v, $k, $collection);
        }

        $this->wrapped = $collection;

        return $this;
    }

    public function reduce($iterator, $initial = null)
    {
        $collection = clone $this->wrapped;

        $reduced = array_reduce($collection, $iterator, $initial);

        $this->wrapped = $reduced;

        return $this;
    }

    public function reduceRight($iterator, $initial = null)
    {
        $collection = clone $this->wrapped;

        krsort($collection);

        $reduced = array_reduce($collection, $iterator, $initial);

        $this->wrapped = $reduced;

        return $this;
    }

    public function pluck($key)
    {
        return $this->map(
            function ($v) use ($key) {
                return is_array($v) ? $v[$key] : $v->{$key};
            }
        );
    }

    public function contains($needle)
    {
        $collection = clone $this->wrapped;

        $this->wrapped = array_search($collection, $needle, true) !== false;

        return $this;
    }

//    public function invoke($collection = null, $function_name = null, $arguments = null)
//    public function any($collection = null, $iterator = null)
//    public function all($collection = null, $iterator = null)
//    public function filter($collection = null, $iterator = null)
//    public function reject($collection = null, $iterator = null)
//    public function find($collection = null, $iterator = null)
//    public function size($collection = null)
//    public function head($collection = null, $n = null)
//    public function tail($collection = null, $index = null)
//    public function initial($collection = null, $n = null)
//    public function last($collection = null, $n = null)
//    public function compact($collection = null)
//    public function flatten($collection = null, $shallow = null)
//    public function without($collection = null, $val = null)
//    public function uniq($collection = null, $is_sorted = null, $iterator = null)
//    public function intersection($array = null)
//    public function union($array = null)
//    public function difference($array_one = null, $array_two = null)
//    public function indexOf($collection = null, $item = null)
//    public function lastIndexOf($collection = null, $item = null)
//    public function range($stop = null)
//    public function zip($array = null)
//    public function max($collection = null, $iterator = null)
//    public function min($collection = null, $iterator = null)
//    public function sortBy($collection = null, $iterator = null)
//    public function groupBy($collection = null, $iterator = null)
//    public function sortedIndex($collection = null, $value = null, $iterator = null)
//    public function shuffle($collection = null)
//    public function toArray($collection = null)
//    public function keys($collection = null)
//    public function values($collection = null)
//    public function extend($object = null)
//    public function defaults($object = null)
//    public function methods($object = null)
//    public function clon(&$object = null)
//    public function tap($object = null, $interceptor = null)
//    public function has($collection = null, $key = null)
//    public function isEqual($a = null, $b = null)
//    public function isEmpty($item = null)
//    public function isObject($item = null)
//    public function isArray($item = null)
//    public function isString($item = null)
//    public function isNumber($item = null)
//    public function isBoolean($item = null)
//    public function isFunction($item = null)
//    public function isDate($item = null)
//    public function isNaN($item = null)
//    public function identity()
//    public function uniqueId($prefix = null)
//    public function times($n = null, $iterator = null)
//    public function mixin($functions = null)
//    public function memoize($function = null, $hashFunction = null)
//    public function throttle($function = null, $wait = null)
//    public function once($function = null)
//    public function wrap($function = null, $wrapper = null)
//    public function compose()
//    public function after($count = null, $function = null)
}
