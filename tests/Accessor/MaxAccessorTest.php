<?php

namespace Underscore\Test\Accessor;

use Underscore\Accessor;
use Underscore\Collection;

class MaxAccessorTest extends BaseAccessorTest
{
    /**
     * @inheritDoc
     */
    protected function getInstance()
    {
        return new Accessor\MaxAccessor();
    }

    /**
     * @inheritDoc
     */
    public function getTestInvokeData()
    {
        $ret = [];

        $ret[] = [
            'qux',
            [new Collection($this->getDummy2())],
        ];

        $ret[] = [
            1,
            [new Collection($this->getDummy4())],
        ];

        return $ret;
    }
}
