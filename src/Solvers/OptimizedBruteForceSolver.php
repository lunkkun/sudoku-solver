<?php

namespace Lunkkun\Sudoku\Solvers;

use Lunkkun\Sudoku\Board;
use Lunkkun\Sudoku\Solver;
use Lunkkun\Sudoku\Solvers\OptimizedBruteForce\OptimizedBruteForceSolverBoard;

class OptimizedBruteForceSolver extends BaseSolver implements Solver
{
    /** @var OptimizedBruteForceSolverBoard */
    protected $original;
    /** @var OptimizedBruteForceSolverBoard */
    protected $board;

    public function __construct(Board $unsolved)
    {
        parent::__construct(OptimizedBruteForceSolverBoard::fromBase($unsolved));
    }

    public function solve(): void
    {
        $missing = $this->board->getMissing();
        $fillable = $this->board->getEmpty();

        $options = [];
        foreach ($fillable as $row => $values) {
            $optionsForRow = [];
            $missingForRow = $missing[$row];
            foreach ($values as $col => &$value) {
                $optionsForRow[$col] = [
                    &$value,
                    $missingForRow,
                ];
            }
            $options[] = [
                $optionsForRow,
                $missingForRow,
            ];
        }

        while (($row = key($options)) !== null) {
            // `current()` is no longer by reference since 7.0.0
            //[&$optionsForRow, &$missingForRow] = current($options);
            [&$optionsForRow, &$missingForRow] = $options[$row];

            while (($col = key($optionsForRow)) !== null) {
                // `current()` is no longer by reference since 7.0.0
                //[&$value, &$optionsForCol] = current($optionsForRow);
                [&$value, &$optionsForCol] = $optionsForRow[$col];

                if ($value !== 0) {
                    $missingForRow[$value] = true;
                    $value = 0;
                }

                while (($option = key($optionsForCol)) !== null) {
                    next($optionsForCol);

                    if ($missingForRow[$option] && $this->board->try($row, $col, $option)) {
                        $missingForRow[$option] = false;
                        $value = $option;
                        next($optionsForRow);

                        if (key($optionsForRow) === null) {
                            end($optionsForRow);
                            next($options);
                            continue 3;
                        }

                        continue 2;
                    }
                }

                reset($optionsForCol);
                prev($optionsForRow);
            }

            reset($optionsForRow);
            prev($options);
        }
    }
}
