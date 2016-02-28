<?php

namespace Underscore\Mutator;

use Underscore\Collection;
use Underscore\Mutator;

class ShuffleMutator extends Mutator
{
    /**
     * Shuffles the values of a collection while preserving the keys.
     *
     * @param Collection $collection
     * @return Collection
     */
    public function __invoke($collection)
    {
        $values = $this->shuffleAssoc($collection->toArray());

        return $this->copyCollectionWith($collection, $values);
    }

    /**
     * Shuffle an array while preserving keys.
     *
     * @param array $values
     *
     * @return array
     */
    private function shuffleAssoc(array $values)
    {
        $keys = array_keys($values);
        shuffle($keys);

        $output = [];
        foreach ($keys as $key) {
            $output[$key] = $values[$key];
        }

        return $output;
    }
}
