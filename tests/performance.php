<?php

require __DIR__ . '/../vendor/autoload.php';

$unsolved = include(__DIR__ . '/../data/test/puzzle.php');

$board = new \Lunkkun\Sudoku\Board($unsolved);

$start = microtime(true);
$solver = new \Lunkkun\Sudoku\Solvers\BruteForceSolver($board);
$solver->solve();
$end = microtime(true);

echo "Brute force: " . ($end - $start) . PHP_EOL;

unset($solver);

$start = microtime(true);
$solver = new \Lunkkun\Sudoku\Solvers\PermutationsSolver($board);
$solver->solve();
$end = microtime(true);

echo "Permutations: " . ($end - $start) . PHP_EOL;
