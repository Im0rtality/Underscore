<?php

namespace Underscore\Test\Accessor;

use Underscore\Accessor\SizeAccessor;

class SizeAccessorTest extends BaseAccessorTest
{
    /**
     * @inheritDoc
     */
    protected function getInstance()
    {
        return new SizeAccessor();
    }

    /**
     * @return array
     */
    public function getTestInvokeData()
    {
        $ret = [];

        $ret[] = [$this->getDummy1(), 3];
        $ret[] = [$this->getDummy2(), 6];

        return $ret;
    }
}
