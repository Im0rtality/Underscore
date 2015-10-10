<?php

namespace Underscore\Test\Accessor;

use Underscore\Accessor;
use Underscore\Collection;

class ContainsAccessorTest extends BaseAccessorTest
{
    /**
     * @inheritDoc
     */
    protected function getInstance()
    {
        return new Accessor\ContainsAccessor();
    }

    /**
     * @inheritDoc
     */
    public function getTestInvokeData()
    {
        $ret = [];

        $ret[] = [
            true,
            [new Collection($this->getDummy1()), 'bar'],
        ];

        $ret[] = [
            false,
            [new Collection($this->getDummy1()), 'baz'],
        ];

        return $ret;
    }
}
