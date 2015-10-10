<?php

namespace Underscore\Test\Mutator;

use Underscore\Collection;
use Underscore\Mutator;

class FilterMutatorTest extends BaseMutatorTest
{
    /**
     * @inheritDoc
     */
    protected function getInstance()
    {
        return new Mutator\FilterMutator();
    }

    /**
     * @inheritDoc
     */
    public function getTestInvokeData()
    {
        $func = function ($value) {
            return 3 < strlen($value);
        };

        $ret = [];

        $ret[] = [
            ['name' => 'dummy'],
            [new Collection($this->getDummy1()), $func],
        ];

        return $ret;
    }
}
