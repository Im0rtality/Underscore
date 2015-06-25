<?php

namespace Underscore\Mutator;

use Underscore\Collection;
use Underscore\Mutator;

/**
 * Class ZipMutator
 * @package Underscore\Mutator
 */
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
        /** @noinspection PhpParamsInspection */
        $values = call_user_func(new ValuesMutator(), $collection)->toArray();
        /** @noinspection PhpParamsInspection */
        $keys = call_user_func(new ValuesMutator(), $this->wrap($keys))->toArray();

        if (count($values) !== count($keys)) {
            throw new \LogicException('Keys and values count must match');
        }

        $newCollection = array();

        foreach ($values as $index => $value) {
            $newCollection[$keys[$index]] = $value;
        }

        return $this->wrap($newCollection);
    }
}
