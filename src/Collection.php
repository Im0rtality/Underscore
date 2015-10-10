<?php

namespace Underscore;

class Collection extends \ArrayObject
{
    public function __construct($input)
    {
        if (is_object($input)) {
            if ($input instanceof \Traversable) {
                $input = iterator_to_array($input);
            } else {
                $input = get_object_vars($input);
            }
        }
        parent::__construct($input, static::ARRAY_AS_PROPS);
    }

    /**
     * @return \ArrayIterator
     */
    public function getIteratorReversed()
    {
        $iterator   = $this->getIteratorClass();
        $collection = array_reverse($this->getArrayCopy());

        return new $iterator($collection);
    }

    /**
     * @return mixed
     */
    public function value()
    {
        return $this->toArray();
    }

    /**
     * @return mixed[]
     */
    public function toArray()
    {
        return $this->getArrayCopy();
    }
}
