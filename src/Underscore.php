<?php

namespace Underscore;

/**
 * @method static Underscore from($item)
 * @method static Underscore range(int $start, int $stop, int $step = 1)
 * @method static Underscore times(int $count, int $function, int $step = 1)
 *
 * @method Underscore clone()
 * @method Underscore compact()
 * @method Underscore defaults(mixed $default, ...)
 * @method Underscore difference($values)
 * @method Underscore extend(mixed $source, ...)
 * @method Underscore filter(callable $iterator)
 * @method Underscore flatten()
 * @method Underscore groupBy(callable $iterator)
 * @method Underscore head(int $count = 1)
 * @method Underscore initial(int $count = 1)
 * @method Underscore invoke(callable $iterator)
 * @method Underscore keys()
 * @method Underscore last(int $count = 1)
 * @method Underscore map(callable $iterator)
 * @method Underscore pick(mixed $key)
 * @method Underscore merge($values)
 * @method Underscore intersection($values)
 * @method Underscore reject(callable $iterator)
 * @method Underscore sortBy(callable $iterator)
 * @method Underscore tail(int $count = 1)
 * @method Underscore tap(callable $iterator)
 * @method Underscore thru(callable $iterator)
 * @method Underscore uniq()
 * @method Underscore values()
 * @method Underscore where(array $properties, $strict = true)
 * @method Underscore without($values)
 * @method Underscore zip(array $keys)
 *
 * @method Collection collection()
 * @method bool       all(callable $iterator)
 * @method bool       any(callable $iterator)
 * @method bool       contains(mixed $needle)
 * @method bool       find(callable $iterator)
 * @method mixed      value()
 * @method mixed[]    toArray()
 * @method int        size()
 * @method mixed      min()
 * @method mixed      max()
 * @method boolean    has($key)
 * @method mixed      reduce(callable $iterator, mixed $initial = null)
 * @method mixed      reduceRight(callable $iterator, mixed $initial = null)
 */
class Underscore
{
    /** @var  Collection */
    protected $wrapped;

    /** @var array */
    protected static $mixins = [];

    /** @var Registry */
    protected static $registry;

    /**
     * Set the registry singleton.
     *
     * @param  Registry $registry
     * @return void
     */
    public static function setRegistry(Registry $registry)
    {
        static::$registry = $registry;
    }

    /**
     * Get the registry singleton.
     *
     * Creates a new registry if none exists.
     *
     * @return Registry
     */
    public static function getRegistry()
    {
        if (!static::$registry) {
            static::$registry = new Registry;
        }

        return static::$registry;
    }

    /**
     * Allows you to extend Underscore with your own utility functions.
     *
     * Pass a hash of {name: function} definitions to have your functions added
     * to the Underscore object, as well as the OOP wrapper.
     *
     * @param  array $functions
     * @return void
     */
    public static function mixin(array $functions)
    {
        foreach ($functions as $name => $function) {
            static::$registry->alias($name, $function);
        }
    }

    /**
     * Fetch a callable payload from mixins.
     *
     * @return callable|null
     */
    protected static function fromMixin($method)
    {
        if (!empty(static::$mixins[$method])) {
            return static::$mixins[$method];
        }
    }

    /**
     * @param Collection $wrapped
     */
    public function __construct(Collection $wrapped = null)
    {
        $this->wrapped = $wrapped;
    }

    /**
     * @param string $method
     * @param array  $args
     * @throws \BadMethodCallException
     * @return $this
     */
    public function __call($method, $args)
    {
        return $this->executePayload(static::getRegistry()->instance($method), $args);
    }

    /**
     * @param string $method
     * @param array  $args
     * @return $this
     */
    public static function __callStatic($method, $args)
    {
        return call_user_func_array(static::getRegistry()->instance($method), $args);
    }

    /**
     * Payload is either Mutator or Accessor. Both are supposed to be callable.
     *
     * @param callable $payload
     * @param array    $args
     * @return $this|mixed
     */
    protected function executePayload($payload, $args)
    {
        array_unshift($args, $this->wrapped);

        if ($payload instanceof Mutator) {
            /** @var $payload callable */
            $this->wrapped = call_user_func_array($payload, $args);

            return $this;
        } else {
            return call_user_func_array($payload, $args);
        }
    }
}
