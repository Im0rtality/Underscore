<?php

namespace Underscore\Test\Mutator;

use Underscore\Collection;
use Underscore\Mutator;

class MergeMutatorTest extends BaseMutatorTest
{
    /**
     * @inheritDoc
     */
    protected function getInstance()
    {
        return new Mutator\MergeMutator();
    }

    /**
     * @inheritDoc
     */
    public function getTestInvokeData()
    {
        $ret = [];

        $ret[] = [
            [
                'name'  => 'dummy',
                'foo'   => 'bar',
                'baz'   => 'qux',
                'false' => false,
                'null'  => null,
                'zero'  => 0,
            ],
            [new Collection($this->getDummy1()), new Collection($this->getDummy2())],
        ];

        return $ret;
    }
}
