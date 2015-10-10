<?php

namespace Underscore\Test\Accessor;

use Underscore\Accessor;
use Underscore\Collection;

class SizeAccessorTest extends BaseAccessorTest
{
    /**
     * @inheritDoc
     */
    protected function getInstance()
    {
        return new Accessor\SizeAccessor();
    }

    /**
     * @inheritDoc
     */
    public function getTestInvokeData()
    {
        $ret = [];

        $ret[] = [
            3,
            [new Collection($this->getDummy1())],
        ];

        $ret[] = [
            6,
            [new Collection($this->getDummy2())],
        ];

        return $ret;
    }
}
