<?php

namespace Lunkkun\Sudoku\Solvers\Permutations;

use Lunkkun\CachingGenerator\CachingGenerator;
use Lunkkun\PermutationsGenerator\PermutationsGenerator as BaseGenerator;

class PermutationsGenerator extends CachingGenerator
{
    public function __construct(array $values)
    {
        parent::__construct((new BaseGenerator($values))->getInnerIterator());
    }
}
