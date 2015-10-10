<?php

namespace Underscore\Test\Mutator;

use Underscore\Collection;
use Underscore\Mutator;

class WithoutMutatorTest extends BaseMutatorTest
{
    /**
     * @inheritDoc
     */
    protected function getInstance()
    {
        return new Mutator\WithoutMutator();
    }

    /**
     * @inheritDoc
     */
    public function getTestInvokeData()
    {
        $ret = [];

        $ret[] = [
            ['foo' => 'bar', 'baz' => 'qux'],
            [new Collection($this->getDummy1()), ['dummy']],
        ];

        return $ret;
    }
}
