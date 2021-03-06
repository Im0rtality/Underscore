<?php

namespace Underscore\Mutator;

use Underscore\Collection;
use Underscore\Mutator;

class ZipMutator extends Mutator
{
    /**
     * Combines current collection values with given keys to produce new collection
     *
     * @param Collection $collection
     * @param mixed[]    $keys
     * @return Collection
     * @throws \LogicException
     */
    public function __invoke($collection, $keys)
    {
        $values = call_user_func(new ValuesMutator, $collection)->toArray();
        $keys = call_user_func(new ValuesMutator, new Collection($keys))->toArray();

        if (count($values) !== count($keys)) {
            throw new \LogicException('Keys and values count must match');
        }

        $newCollection = [];

        foreach ($values as $index => $value) {
            $newCollection[$keys[$index]] = $value;
        }

        return $this->copyCollectionWith($collection, $newCollection);
    }
}
