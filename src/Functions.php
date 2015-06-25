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
     * Wraps the first function inside of the wrapper function, passing it as the first argument.
     *
     * This allows the wrapper to execute code before and after the function runs,
     * adjust the arguments, and execute it conditionally.
     *
     * @param callable $function
     * @param callable $wrapper
     * @return \Closure
     */
    public static function wrap($function, $wrapper)
    {
        return function ($args = null) use ($function, $wrapper) {
            $args = func_get_args() ?: array();
            array_unshift($args, $function); // make $function the first argument
            return call_user_func_array($wrapper, $args);
        };
    }
}
