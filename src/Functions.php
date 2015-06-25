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
}
