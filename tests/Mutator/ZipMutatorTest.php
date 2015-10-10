<?php

namespace Underscore\Test\Mutator;

use Underscore\Collection;
use Underscore\Mutator;

class ZipMutatorTest extends BaseMutatorTest
{
    /**
     * @inheritDoc
     */
    protected function getInstance()
    {
        return new Mutator\ZipMutator();
    }

    /**
     * @inheritDoc
     */
    public function getTestInvokeData()
    {
        $ret = [];

        $ret[] = [
            [
                'a'  => 'dummy',
                1    => 'bar',
                '42' => 'qux',
            ],
            [new Collection($this->getDummy1()), ['a', 1, '42']],
        ];

        return $ret;
    }

    /**
     * @expectedException \LogicException
     */
    public function testThrowIfWrongDimmensions()
    {
        $this->getInstance()->__invoke(new Collection($this->getDummy1()), ['a']);
    }
}
