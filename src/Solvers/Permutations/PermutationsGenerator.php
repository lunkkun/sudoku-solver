<?php

namespace Lunkkun\Sudoku\Solvers\Permutations;

use Generator;
use Iterator;

class PermutationsGenerator extends CachedGenerator implements Iterator
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
            $remaining = $values;
            array_splice($remaining, $key, 1);
            foreach ($this->generator($remaining) as $permutation) {
                $permutation[] = $value;
                yield $permutation;
            }
        }
    }
}
