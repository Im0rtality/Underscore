<?php

namespace Underscore;

/**
 * Callable registry for Underscore methods.
 *
 * It is assumed that all callables will be classes with an `__invoke` method.
 *
 * Existing methods can be overloaded by setting an alias of the same name:
 *
 *     $registry->alias('keys', 'Acme\KeysMutator');
 *
 * New methods can be added in the same way:
 *
 *     $registry->alias('fancy', 'Acme\FancyInitializer');
 *
 * Every alias is a singleton and will only be created once! If your callable
 * requires construction, alias a fully constructed object instead:
 *
 *     $registry->alias('fancy', new FancyInitializer($parameters));
 *
 * NOTE: Mutators, accessors, and initializers all use the same registery and
 * differ only in how they are used internally by Underscore.
 */
class Registry
{
    /**
     * @var array Classes aliased by name of method.
     */
    private $aliases = [];

    /**
     * @var array Callable instances aliased by name of method.
     */
    private $instances = [];

    /**
     * @param array $aliases
     */
    public function __construct(array $aliases = [])
    {
        $this->aliases = $aliases;
    }

    /**
     * Get the callable for an Underscore method alias.
     *
     * @param  string $name
     * @return callable
     */
    public function instance($name)
    {
        if (empty($this->instances[$name])) {
            if (empty($this->aliases[$name])) {
                $this->aliasDefault($name);
            }
            $this->instances[$name] = new $this->aliases[$name];
        }

        return $this->instances[$name];
    }

    /**
     * Alias method name to a callable.
     *
     * @param  string $name
     * @param  callable $spec
     * @return void
     */
    public function alias($name, $spec)
    {
        if (is_callable($spec)) {
            $this->instances[$name] = $spec;
        } else {
            $this->aliases[$name] = $spec;

            // Ensure that the new alias will be used when called.
            unset($this->instances[$name]);
        }
    }

    /**
     * Define a default mutator, accessor, or initializer for a method name.
     *
     * @throws BadMethodCallException If no default can be located.
     * @param  string $name
     * @return void
     */
    private function aliasDefault($name)
    {
        $spec = sprintf('\Underscore\Mutator\%sMutator', ucfirst($name));

        if (!class_exists($spec)) {
            $spec = sprintf('\Underscore\Accessor\%sAccessor', ucfirst($name));
        }

        if (!class_exists($spec)) {
            $spec = sprintf('\Underscore\Initializer\%sInitializer', ucfirst($name));
        }

        if (!class_exists($spec)) {
            throw new \BadMethodCallException(sprintf('Unknown method Underscore->%s()', $name));
        }

        $this->aliases[$name] = $spec;
    }
}
