<?php

namespace Underscore\Test\Mutator;

use Underscore\Collection;
use Underscore\Mutator;

class TailMutatorTest extends BaseMutatorTest
{
    /**
     * @inheritDoc
     */
    protected function getInstance()
    {
        return new Mutator\TailMutator();
    }

    /**
     * @inheritDoc
     */
    public function getTestInvokeData()
    {
        $ret = [];

        $ret[] = [
            ['foo' => 'bar', 'baz' => 'qux'],
            [new Collection($this->getDummy1()), 1],
        ];

        return $ret;
    }
}
