<?php

namespace Underscore\Test\Accessor;

use Underscore\Accessor;
use Underscore\Collection;

class AllAccessorTest extends BaseAccessorTest
{
    /**
     * @inheritDoc
     */
    protected function getInstance()
    {
        return new Accessor\AllAccessor();
    }

    /**
     * @inheritDoc
     */
    public function getTestInvokeData()
    {
        $func = function ($value) {
            return 3 <= strlen($value);
        };
        $ret = [];

        $ret[] = [
            true,
            [new Collection($this->getDummy1()), $func],
        ];

        $ret[] = [
            false,
            [new Collection($this->getDummy2()), $func],
        ];

        return $ret;
    }
}
