<?php

namespace Underscore\Test\Accessor;

use Underscore\Accessor;
use Underscore\Collection;

class ReduceAccessorTest extends BaseAccessorTest
{
    /**
     * @inheritDoc
     */
    protected function getInstance()
    {
        return new Accessor\ReduceAccessor();
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
            'dummy bar qux ',
            [new Collection($this->getDummy1()), $func],
        ];

        return $ret;
    }
}
