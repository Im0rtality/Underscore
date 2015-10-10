<?php

namespace Underscore\Test\Accessor;

use Underscore\Accessor;
use Underscore\Collection;

class ValueAccessorTest extends BaseAccessorTest
{
    /**
     * @inheritDoc
     */
    protected function getInstance()
    {
        return new Accessor\ValueAccessor();
    }

    /**
     * @inheritDoc
     */
    public function getTestInvokeData()
    {
        $ret = [];

        $ret[] = [
            (array) $this->getDummy1(),
            [new Collection($this->getDummy1())],
        ];

        $ret[] = [
            (array) $this->getDummy2(),
            [new Collection($this->getDummy2())],
        ];

        return $ret;
    }
}
