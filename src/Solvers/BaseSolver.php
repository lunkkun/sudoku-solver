<?php

namespace Lunkkun\Sudoku\Solvers;

use Lunkkun\Sudoku\Board;
use Lunkkun\Sudoku\Solver;

abstract class BaseSolver implements Solver
{
    /** @var Board */
    protected $original;
    /** @var Board */
    protected $board;

    public function __construct(Board $unsolved)
    {
        $this->original = $unsolved;
        $this->board = $unsolved->copy();
    }

    public function getBoard(): Board
    {
        return $this->board;
    }
}
