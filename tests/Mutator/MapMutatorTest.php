<?php

namespace Underscore\Test\Mutator;

use Underscore\Collection;
use Underscore\Mutator;

class MapMutatorTest extends BaseMutatorTest
{
    /**
     * @inheritDoc
     */
    protected function getInstance()
    {
        return new Mutator\MapMutator();
    }

    /**
     * @inheritDoc
     */
    public function getTestInvokeData()
    {
        $func = function ($value, $key) {
            return sprintf('%s:%s', $key, $value);
        };

        $ret = [];

        $ret[] = [
            ['name' => 'name:dummy', 'foo' => 'foo:bar', 'baz' => 'baz:qux'],
            [new Collection($this->getDummy1()), $func],
        ];

        return $ret;
    }
}
