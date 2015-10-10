<?php

namespace Underscore\Test\Mutator;

use Underscore\Collection;
use Underscore\Mutator;
use Underscore\Test\Dummy;

class PickMutatorTest extends BaseMutatorTest
{
    /**
     * @inheritDoc
     */
    protected function getInstance()
    {
        return new Mutator\PickMutator();
    }

    /**
     * @inheritDoc
     */
    public function getTestInvokeData()
    {
        $ret = [];

        $ret[] = [
            ['bar', 'bar'],
            [new Collection([$this->getDummy1(), $this->getDummy1()]), 'foo'],
        ];

        $ret[] = [
            ['foo'],
            [new Collection([new Dummy()]), 'getFoo'],
        ];

        return $ret;
    }
}
