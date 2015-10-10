<?php

namespace Underscore\Test\Accessor;

use Underscore\Accessor;
use Underscore\Collection;

class ReduceRightAccessorTest extends BaseAccessorTest
{
    /**
     * @inheritDoc
     */
    protected function getInstance()
    {
        return new Accessor\ReduceRightAccessor();
    }

    /**
     * @inheritDoc
     */
    public function getTestInvokeData()
    {
        $func = function ($accu, $value) {
            $accu .= $value . ' ';

            return $accu;
        };
        $ret = [];

        $ret[] = [
            'qux bar dummy ',
            [new Collection($this->getDummy1()), $func],
        ];

        return $ret;
    }
}
