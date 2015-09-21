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
 * @method mixed    min()
 * @method mixed    max()
 * @method boolean  has($key)
 */
class Underscore
{
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
        $payloadClass = sprintf('\Underscore\Mutator\%sMutator', ucfirst($method));
        if (!class_exists($payloadClass)) {
            $payloadClass = sprintf('\Underscore\Accessor\%sAccessor', ucfirst($method));
        }

        if (!class_exists($payloadClass)) {
            throw new \BadMethodCallException("Unknown method Underscore->{$method}()");
        }

        /** @var $payload callable */
        $payload = new $payloadClass();

        return $this->executePayload($payload, $args);
    }

    /**
     * @param string $method
     * @param array  $args
     * @return $this
     */
    public static function __callStatic($method, $args)
    {
        $payloadClass = sprintf('\Underscore\Initializer\%sInitializer', ucfirst($method));
        /** @var $payload callable */
        $payload = new $payloadClass();

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
