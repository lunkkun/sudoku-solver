<?php

namespace Lunkkun\Sudoku\Solvers\Permutations;

use Lunkkun\Sudoku\Board;

class PermutationsSolverBoard extends Board
{
    public static function fromBase(Board $board): self
    {
        return new static($board->rows);
    }

    public function getEmpty(): array
    {
        $empty = [];

        foreach ($this->rows as $row => &$values) {
            $emptyForRow = [];
            foreach ($values as $col => &$value) {
                if ($value === 0) {
                    $emptyForRow[$col] = &$value;
                }
            }
            $empty[$row] = $emptyForRow;
        }

        return $empty;
    }

    public function getMissingForRow(int $row): array
    {
        return array_diff(range(0, 9), $this->rows[$row]);
    }
}
