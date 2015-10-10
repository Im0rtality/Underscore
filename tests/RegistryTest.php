<?php

namespace Underscore\Test;

use Underscore\Registry;

class RegistryTest extends \PHPUnit_Framework_TestCase
{
    public function testDefault()
    {
        $registry = new Registry();

        $this->assertInstanceOf('Underscore\Accessor\ValueAccessor', $registry->instance('value'));
        $this->assertInstanceOf('Underscore\Initializer\FromInitializer', $registry->instance('from'));
        $this->assertInstanceOf('Underscore\Mutator\LastMutator', $registry->instance('last'));
    }

    public function testConstructorAlias()
    {
        $registry = new Registry([
            'last' => 'Underscore\Test\Fixture\Mutator\ChefMutator',
        ]);

        $this->assertInstanceOf('Underscore\Test\Fixture\Mutator\ChefMutator', $registry->instance('last'));
    }

    public function testAliasSpec()
    {
        $registry = new Registry();

        $this->assertInstanceOf('Underscore\Mutator\LastMutator', $registry->instance('last'));

        $registry->alias('last', 'Underscore\Test\Fixture\Mutator\ChefMutator');

        $this->assertInstanceOf('Underscore\Test\Fixture\Mutator\ChefMutator', $registry->instance('last'));
    }

    public function testAliasConcrete()
    {
        $registry = new Registry();

        $accessor = function ($collection) {
        };

        $registry->alias('fin', $accessor);

        $this->assertSame($accessor, $registry->instance('fin'));
    }

    /**
     * @expectedException BadMethodCallException
     */
    public function testMissingInstance()
    {
        $registry = new Registry();

        $registry->instance('invalid');
    }
}
