<?php

namespace Underscore\Test;

use Underscore\Underscore;
use Underscore\Test\Fixture\Collection\TestCollection;

class CollectionCopyTest extends \PHPUnit_Framework_TestCase
{
    public function dataMutate()
    {
        return [
            [
                'Underscore\Mutator\FilterMutator',
                function ($value) {
                    return true;
                },
            ],
            [
                'Underscore\Mutator\FlattenMutator',
            ],
            [
                'Underscore\Mutator\GroupByMutator',
                function ($value) {
                    return $value;
                },
            ],
            [
                'Underscore\Mutator\HeadMutator',
            ],
            [
                'Underscore\Mutator\InitialMutator',
            ],
            [
                'Underscore\Mutator\KeysMutator',
            ],
            [
                'Underscore\Mutator\LastMutator',
            ],
            [
                'Underscore\Mutator\TailMutator',
            ],
            [
                'Underscore\Mutator\ThruMutator',
                function ($values) {
                    return $values;
                },
            ],
            [
                'Underscore\Mutator\ZipMutator',
                [],
            ],
        ];
    }

    /**
     * @dataProvider dataMutate
     */
    public function testMutate($mutator)
    {
        // Get all arguments for the mutator
        $args = func_get_args();

        // Create the mutator class from the first argument
        $mutator = array_shift($args);
        $mutator = new $mutator;

        // Create a new (empty) collection
        $collection = new TestCollection([]);

        // Set the first argument to be the collection
        array_unshift($args, $collection);

        // Call the mutator to create a new collection
        $modified = call_user_func_array($mutator, $args);

        // The collection should not be the same
        $this->assertNotSame($collection, $modified);

        // But should be the same type
        $this->assertInstanceOf(get_class($collection), $modified);
    }
}
