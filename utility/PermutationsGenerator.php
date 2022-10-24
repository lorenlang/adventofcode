<?php

namespace Utility;

use Generator;
use IteratorIterator;

class PermutationsGenerator extends IteratorIterator
{
    public function __construct(array $values)
    {
        parent::__construct($this->generator($values));
    }

    protected function generator(array $values): Generator
    {
        if (count($values) === 1) {
            yield $values;
            return;
        }

        foreach ($values as $key => $value) {
            $remaining = [];
            foreach ($values as $k => $v) {
                if ($k !== $key) {
                    $remaining[] = $v;
                }
            }

            foreach ($this->generator($remaining) as $permutation) {
                $permutation[] = $value;
                yield $permutation;
            }
        }
    }
}
