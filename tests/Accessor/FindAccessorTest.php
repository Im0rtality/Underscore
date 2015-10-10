<?php

namespace Underscore\Test\Accessor;

use Underscore\Accessor;
use Underscore\Collection;

class FindAccessorTest extends BaseAccessorTest
{
    /**
     * @inheritDoc
     */
    protected function getInstance()
    {
        return new Accessor\FindAccessor();
    }

    /**
     * @inheritDoc
     */
    public function getTestInvokeData()
    {
        $func = function ($needle) {
            return function ($value) use ($needle) {
                return $value === $needle;
            };
        };

        $ret = [];

        $ret[] = [
            false,
            [new Collection($this->getDummy1()), $func('foo')],
        ];

        $ret[] = [
            true,
            [new Collection($this->getDummy1()), $func('bar')],
        ];

        return $ret;
    }
}
