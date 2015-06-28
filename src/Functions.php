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
}
