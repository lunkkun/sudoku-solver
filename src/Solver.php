<?php

namespace Lunkkun\Sudoku;

interface Solver
{
    public function getBoard(): Board;

    public function solve(): void;
}
