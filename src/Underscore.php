<?php

namespace Underscore;

/**
 * @method static Underscore from($item)
 * @method static Underscore range(int $start, int $stop, int $step = 1)
 * @method static Underscore times(int $count, int $function, int $step = 1)
 *
 * @method Underscore all(callable $iterator)
 * @method Underscore any(callable $iterator)
 * @method Underscore clone()
 * @method Underscore compact()
 * @method Underscore contains(mixed $needle)
 * @method Underscore defaults(mixed $default, ...)
 * @method Underscore extend(mixed $source, ...)
 * @method Underscore filter(callable $iterator)
 * @method Underscore find(callable $iterator)
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
 * @method Underscore reduce(callable $iterator, mixed $initial = null)
 * @method Underscore reduceRight(callable $iterator, mixed $initial = null)
 * @method Underscore reject(callable $iterator)
 * @method Underscore sortBy(callable $iterator)
 * @method Underscore tail(int $count = 1)
 * @method Underscore tap(callable $iterator)
 * @method Underscore uniq()
 * @method Underscore values()
 * @method Underscore without($values)
 * @method Underscore zip(array $keys)
 *
 * @method mixed    value()
 * @method mixed[]  toArray()
 * @method int      size()
 */
class Underscore
{
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

    /** @var  Collection */
    protected $wrapped;

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
        /** @var $payload callable */
        $payload = static::getRegistry()->instance($method);

        return $this->executePayload($payload, $args);
    }

    /**
     * @param string $method
     * @param array  $args
     * @return $this
     */
    public static function __callStatic($method, $args)
    {
        /** @var $payload callable */
        $payload = static::getRegistry()->instance($method);

        return call_user_func_array($payload, $args);
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
