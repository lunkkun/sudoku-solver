<?php

namespace Lunkkun\Sudoku\Solvers\Permutations;

use Lunkkun\CachedGenerator\CachedGenerator;

class PermutationsGenerator extends CachedGenerator
{
    public function __construct(array $values)
    {
        $generator = new \Lunkkun\PermutationsGenerator\PermutationsGenerator();
        parent::__construct($generator($values));
    }
}
