<?php
namespace Underscore\Test;

class UnderscoreArraysTest extends MasterTest
{
    protected function getDummy()
    {
        $dummy      = new \stdClass();
        $dummy->foo = 'bar';
        $dummy->baz = 'qux';

        return $dummy;
    }
}
