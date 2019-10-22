<?php

namespace Lunkkun\Sudoku\Tests;

use Lunkkun\Sudoku\Board;
use Lunkkun\Sudoku\Solvers\OptimizedBruteForceSolver;
use PHPUnit\Framework\TestCase;

class OptimizedBruteForceSolverTest extends TestCase
{
    public function testSolvesSudoku(): void
    {
        $unsolved = include(__DIR__ . '/../data/test/puzzle.php');
        $solved = include(__DIR__ . '/../data/test/solved.php');

        $board = new Board($unsolved);
        $solver = new OptimizedBruteForceSolver($board);
        $solver->solve();

        //$this->assertTrue($solver->getBoard()->isSolved());
        $this->assertEquals((string)new Board($solved), (string)$solver->getBoard());
    }
}
