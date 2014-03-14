<?php

namespace Underscore\Test;

/**
 * Class Dummy
 * @package Underscore\Test
 */
class Dummy
{
    public $name = 'dummy';
    public $answer = 42;
    protected $precious = 'the ring';

    /**
     * @return string
     */
    public function getFoo()
    {
        return 'foo';
    }
}
