<?php

namespace Underscore\Test\Accessor;

use Underscore\Accessor;
use Underscore\Collection;

class MinAccessorTest extends BaseAccessorTest
{
    /**
     * @inheritDoc
     */
    protected function getInstance()
    {
        return new Accessor\MinAccessor();
    }

    /**
     * @inheritDoc
     */
    public function getTestInvokeData()
    {
        $ret = [];

        $ret[] = [
            0,
            [new Collection([0, 1, 2])],
        ];

        $ret[] = [
            0,
            [new Collection([0, false, 'foo'])],
        ];

        return $ret;
    }
}
