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

    /**
     * Provides a constant value that is only used for partial().
     *
     * @return \Closure
     */
    public static function p()
    {
        static $function;
        if (!$function) {
            $function = function () {
                return 'placeholder for partial';
            };
        }
        return $function;
    }

    /**
     * Partially apply a function by filling in any number of its arguments.
     *
     * You may pass p() in your list of arguments to specify an argument that
     * should not be pre-filled, but left open to supply at call-time.
     *
     * @param callable $function
     * @param mixed $arg
     * @param mixed ...
     * @return \Closure
     */
    public static function partial($function, $arg)
    {
        $bound = func_get_args();
        array_shift($bound); // remove $function

        $placeholder = static::p();

        return function ($args = null) use ($function, $bound, $placeholder) {
            $inject = func_get_args();

            $args = array();
            foreach ($bound as $value) {
                if ($value === $placeholder) {
                    $args[] = array_shift($inject);
                } else {
                    $args[] = $value;
                }
            }

            // Append any remaining arguments
            $args = array_merge($args, $inject);

            return call_user_func_array($function, $args);
        };
    }

    /**
     * Returns the composition of a list of functions.
     *
     * Each function consumes the return value of the function that follows.
     * In math terms, composing the functions f(), g(), and h() produces f(g(h())).
     *
     * @param callable $function
     * @param callable ...
     * @return \Closure
     */
    public static function compose($function)
    {
        $functions = array_reverse(func_get_args());

        return function ($value) use ($functions) {
            foreach ($functions as $function) {
                $value = $function($value);
            }
            return $value;
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
