<?php

namespace Lunkkun\Sudoku\Solvers\OptimizedBruteForce;

use Lunkkun\Sudoku\Board;

class OptimizedBruteForceSolverBoard extends Board
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

    public function getMissing(): array
    {
        $all = range(0, 9);

        $missing = [];
        foreach ($this->rows as $row) {
            $missing[] = array_fill_keys(array_diff($all, $row), true);
        }

        return $missing;
    }

    public function try(int $row, int $col, int $value): bool
    {
        return $this->tryColumn($col, $value) && $this->tryBox($row, $col, $value);
    }
}
