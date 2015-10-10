<?php

namespace Underscore\Test\Accessor;

use Underscore\Accessor;
use Underscore\Collection;

class HasAccessorTest extends BaseAccessorTest
{
    /**
     * @inheritDoc
     */
    protected function getInstance()
    {
        return new Accessor\HasAccessor();
    }

    /**
     * @inheritDoc
     */
    public function getTestInvokeData()
    {
        $ret = [];

        $ret[] = [
            true,
            [new Collection($this->getDummy1()), 'foo'],
        ];

        $ret[] = [
            false,
            [new Collection($this->getDummy1()), 'bar'],
        ];

        return $ret;
    }
}
