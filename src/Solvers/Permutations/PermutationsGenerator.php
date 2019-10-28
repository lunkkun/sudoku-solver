<?php

namespace Lunkkun\Sudoku\Solvers\Permutations;

use Lunkkun\CachedGenerator\CachedGenerator;

class PermutationsGenerator extends CachedGenerator
{
    public function __construct(array $values)
    {
        parent::__construct($this->generator($values));
    }

    protected function generator(array $values): \Generator
    {
        if (count($values) === 1) {
            yield $values;
            return;
        }

        $remaining = [];
        while (($value = array_pop($values)) !== null) {
            foreach ($this->generator(array_merge($values, $remaining)) as $permutation) {
                $permutation[] = $value;
                yield $permutation;
            }
            $remaining[] = $value;
        }
    }
}
