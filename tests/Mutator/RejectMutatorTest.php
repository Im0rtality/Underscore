<?php

namespace Underscore\Test\Mutator;

use Underscore\Collection;
use Underscore\Mutator;

class RejectMutatorTest extends BaseMutatorTest
{
    /**
     * @inheritDoc
     */
    protected function getInstance()
    {
        return new Mutator\RejectMutator();
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
            ['foo' => 'bar', 'baz' => 'qux'],
            [new Collection($this->getDummy1()), $func],
        ];

        return $ret;
    }
}
