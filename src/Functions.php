<?php

namespace Underscore;

/**
 * Class Functions
 * @package Underscore
 */
class Functions
{
    /**
     * Creates a function that memoizes the result of the $payload
     *
     * @param callable $payload
     *
     * @return \Closure
     */
    public static function memoize($payload)
    {
        $function = function () use ($payload) {
            static $cache = array();
            $args = func_get_args();
            $hash = md5(serialize($args));

            if (!array_key_exists($hash, $cache)) {
                $cache[$hash] = call_user_func_array($payload, $args);
            }
            return $cache[$hash];
        };

        return $function;
    }

    /**
     * Creates function that simply returns given argument
     *
     * @return \Closure
     */
    public static function nop()
    {
        return function ($item) {
            return $item;
        };
    }

    /**
     * Creates a version of the function that can only be called one time.
     *
     * Repeated calls to the modified function will have no effect, returning
     * the value from the original call. Useful for initialization functions,
     * instead of having to set a boolean flag and then check it later.
     *
     * @param callable $function
     * @return \Closure
     */
    public static function once($function)
    {
        $called = false;
        $value  = null;

        return function ($args = null) use ($function, &$called, &$value) {
            if (!$called) {
                $args   = func_get_args();
                $value  = call_user_func_array($function, $args);
                $called = true;
            }
            return $value;
        };
    }
}
