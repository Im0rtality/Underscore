<?php
namespace Underscore\Test;

use Underscore\Underscore;

abstract class MasterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @return Object|mixed|array
     */
    abstract protected function getDummy();

    public function testValue()
    {
        $this->assertEquals($this->getDummy(), Underscore::from($this->getDummy())->value());
    }
}
