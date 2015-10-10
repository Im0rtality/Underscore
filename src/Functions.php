<?php

namespace Underscore;

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

        return function () use ($function, &$called, &$value) {
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

        return function () use ($function, $bound, $placeholder) {
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
        return function () use ($function, $wrapper) {
            $args = func_get_args();
            array_unshift($args, $function); // make $function the first argument
            return call_user_func_array($wrapper, $args);
        };
    }

    /**
     * Creates and returns a new, throttled version of the passed function.
     *
     * When invoked repeatedly, will only actually call the original function at
     * most once per every wait milliseconds. Useful for rate-limiting events that
     * occur faster than you can keep up with.
     *
     * By default, throttle will execute the function as soon as you call it
     * for the first time, and, if you call it again any number of times during
     * the wait period, as soon as that period is over. If you'd like to disable
     * the leading-edge call, pass `leading => false`.
     *
     * NOTE: Does not support the `trailing` option because there is no timeout
     * functionality in PHP (without using threads).
     *
     * NOTE: No arguments are passed to the function on the leading edge call!
     *
     * @param callable $function
     * @param integer  $wait
     * @param array    $options
     * @return \Closure
     */
    public static function throttle($function, $wait, array $options = array())
    {
        $options += array(
            'leading' => true,
        );

        $previous = 0;

        $callback = function () use ($function, $wait, &$previous) {
            $now = floor(microtime(true) * 1000); // convert float to integer

            if (($wait - ($now - $previous)) <= 0) {
                $args = func_get_args();
                call_user_func_array($function, $args);
                $previous = $now;
            }
        };

        if ($options['leading'] !== false) {
            $callback();
        }

        return $callback;
    }

    /**
     * Creates a version of the function that will only be run after first being called count times.
     *
     * Useful for grouping asynchronous responses, where you want to be sure that
     * all the async calls have finished, before proceeding.
     *
     * @param integer $count
     * @param callable $function
     * @return \Closure
     */
    public static function after($count, $function)
    {
        return function () use ($function, &$count) {
            if (--$count < 1) {
                $args = func_get_args();
                return call_user_func_array($function, $args);
            }
        };
    }

    /**
     * Creates a version of the function that can be called no more than count times.
     *
     * The result of the last function call is memoized and returned when count has been reached.
     *
     * @param integer $count
     * @param callable $function
     * @return \Closure
     */
    public static function before($count, $function)
    {
        $memo = null;

        return function () use ($function, &$count, &$memo) {
            if (--$count > 0) {
                $args = func_get_args();
                $memo = call_user_func_array($function, $args);
            }
            return $memo;
        };
    }
}
