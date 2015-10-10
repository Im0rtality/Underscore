<?php

namespace Underscore\Test\Accessor;

use Underscore\Accessor;
use Underscore\Collection;

class AnyAccessorTest extends BaseAccessorTest
{
    /**
     * @inheritDoc
     */
    protected function getInstance()
    {
        return new Accessor\AnyAccessor();
    }

    /**
     * @inheritDoc
     */
    public function getTestInvokeData()
    {
        $func = function ($value) {
            return is_bool($value);
        };
        $ret = [];

        $ret[] = [
            false,
            [new Collection($this->getDummy1()), $func],
        ];

        $ret[] = [
            true,
            [new Collection($this->getDummy2()), $func],
        ];

        return $ret;
    }
}
