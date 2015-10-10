<?php

namespace Underscore\Test\Mutator;

use Underscore\Collection;
use Underscore\Mutator;

class GroupByMutatorTest extends BaseMutatorTest
{
    /**
     * @inheritDoc
     */
    protected function getInstance()
    {
        return new Mutator\GroupByMutator();
    }

    /**
     * @inheritDoc
     */
    public function getTestInvokeData()
    {
        $ret = [];

        $ret[] = [
            [
                5 => ['dummy'],
                3 => ['bar', 'qux'],
            ],
            [new Collection($this->getDummy1()), 'strlen'],
        ];

        return $ret;
    }
}
