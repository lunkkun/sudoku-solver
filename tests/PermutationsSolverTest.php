<?php

namespace Lunkkun\Sudoku\Tests;

use Lunkkun\Sudoku\Board;
use Lunkkun\Sudoku\Solvers\BruteForceSolver;
use Lunkkun\Sudoku\Solvers\PermutationsSolver;
use PHPUnit\Framework\TestCase;

class PermutationsSolverTest extends TestCase
{
    public function testSolvesSudoku(): void
    {
        $unsolved = include('data/test/puzzle.php');
        $solved = include('data/test/solved.php');

        $board = new Board($unsolved);
        $solver = new PermutationsSolver($board);
        $solver->solve();

        //$this->assertTrue($solver->getBoard()->isSolved());
        $this->assertEquals((string)new Board($solved), (string)$solver->getBoard());
    }
}
