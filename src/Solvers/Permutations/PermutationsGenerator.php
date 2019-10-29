<?php

namespace Lunkkun\Sudoku\Solvers\Permutations;

use Lunkkun\CachedGenerator\CachedGenerator;
use Lunkkun\PermutationsGenerator\PermutationsGenerator as BaseGenerator;

class PermutationsGenerator extends CachedGenerator
{
    public function __construct(array $values)
    {
        parent::__construct((new BaseGenerator($values))->getInnerIterator());
    }
}
