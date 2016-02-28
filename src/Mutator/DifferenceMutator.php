<?php

namespace Underscore\Mutator;

use Underscore\Collection;
use Underscore\Mutator;

class DifferenceMutator extends Mutator
{
    /**
     * Finds the difference of two collections.
     *
     * @param Collection $collection
     * @param \Iterator  $values
     * @return Collection
     */
    public function __invoke($collection, $values)
    {
        $collection = clone $collection;

        if (!is_array($values)) {
            $values = iterator_to_array($values);
        }

        $current = $collection->getArrayCopy();

        if ($this->isAssoc($current)) {
            $values = array_diff_assoc($current, $values);
        } else {
            $values = array_diff($current, $values);
        }

        $collection->exchangeArray($values);

        return $collection;
    }

    /**
     * Check if an array is associative.
     *
     * @param array $values
     *
     * @return boolean
     */
    private function isAssoc(array $values)
    {
        $keys = array_keys($values);
        return $keys !== array_keys($keys);
    }
}
