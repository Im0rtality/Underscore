<?php

namespace Underscore;

/**
 * Class Underscore
 * @package Underscore
 *
 * @method static Underscore from($item)
 * @method static Underscore range(int $start, int $stop, int $step = 1)
 *
 * @method Underscore invoke(callable $iterator)
 * @method Underscore reduce(callable $iterator, mixed $initial = null)
 * @method Underscore reduceRight(callable $iterator, mixed $initial = null)
 * @method Underscore map(callable $iterator)
 * @method Underscore pick(mixed $key)
 * @method Underscore all(callable $iterator)
 * @method Underscore any(callable $iterator)
 * @method Underscore filter(callable $iterator)
 * @method Underscore reject(callable $iterator)
 * @method Underscore find(callable $iterator)
 * @method Underscore groupBy(callable $iterator)
 * @method Underscore sortBy(callable $iterator)
 * @method Underscore tap(callable $iterator)
 * @method Underscore contains(mixed $needle)
 * @method Underscore compact()
 * @method Underscore values()
 * @method Underscore keys()
 * @method Underscore flatten()
 * @method Underscore head(int $count = 1)
 * @method Underscore tail(int $count = 1)
 * @method Underscore initial(int $count = 1)
 * @method Underscore last(int $count = 1)
 * @method Underscore zip(array $keys)
 * @method Underscore merge($values)
 * @method Underscore without($values)
 * @method Underscore clone()
 *
 * @method mixed    value()
 * @method mixed[]  toArray()
 * @method int      size()
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
            $payloadClass = sprintf('\Underscore\Accesor\%sAccesor', ucfirst($method));
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
     * Payload is either Mutator or Accesor. Both are supposed to be callable.
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
