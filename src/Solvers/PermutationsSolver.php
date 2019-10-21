<?php

namespace Lunkkun\Sudoku\Solvers;

use Lunkkun\Sudoku\Board;
use Lunkkun\Sudoku\Solvers\Permutations\PermutationsGenerator;
use Lunkkun\Sudoku\Solvers\Permutations\PermutationsSolverBoard;
use Lunkkun\Sudoku\Solver;

class PermutationsSolver extends BaseSolver implements Solver
{
    /** @var PermutationsSolverBoard */
    protected $original;
    /** @var PermutationsSolverBoard */
    protected $board;
    /** @var PermutationsGenerator[] */
    protected $generators;

    public function __construct(Board $unsolved)
    {
        parent::__construct(PermutationsSolverBoard::fromBase($unsolved));
    }

    public function solve(): void
    {
        $empty = &$this->board->getEmpty();

        $row = 0;
        $shouldClean = false;
        while ($row > -1 && $row < 9) {
            $emptyForRow = &$empty[$row];

            if ($shouldClean) {
                foreach ($emptyForRow as $col => &$value) {
                    $value = 0;
                }
                unset($value);
                $shouldClean = false;
            }

            $generator = $this->getGenerator($row);

            while ($generator->valid()) {
                $permutation = array_combine(array_keys($emptyForRow), $generator->current());
                $generator->next();

                if ($this->tryPermutation($row, $permutation)) {
                    foreach ($permutation as $col => $value) {
                        $emptyForRow[$col] = $value;
                    }

                    $row++;
                    continue 2;
                }
            }

            $generator->rewind();
            $row--;
            $shouldClean = true;
        }
    }

    protected function tryPermutation(int $row, array $permutation): bool
    {
        foreach ($permutation as $col => $value) {
            if (!$this->board->tryColumn($col, $value) || !$this->board->tryBox($row, $col, $value)) {
                return false;
            }
        }

        return true;
    }

    protected function getGenerator(int $row): PermutationsGenerator
    {
        if (!array_key_exists($row, $this->generators)) {
            $missing = $this->board->getMissingForRow($row);
            $this->generators[$row] = new PermutationsGenerator($missing);
        }

        return $this->generators[$row];
    }
}
