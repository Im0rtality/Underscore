<?php

namespace Underscore\Test\Mutator;

use Underscore\Collection;
use Underscore\Mutator;

class LastMutatorTest extends BaseMutatorTest
{
    /**
     * @inheritDoc
     */
    protected function getInstance()
    {
        return new Mutator\LastMutator();
    }

    /**
     * @inheritDoc
     */
    public function getTestInvokeData()
    {
        $ret = [];

        $ret[] = [
            ['foo' => 'bar', 'baz' => 'qux'],
            [new Collection($this->getDummy1()), 2],
        ];

        return $ret;
    }
}
