<?php

namespace Lunkkun\Sudoku\Solvers;

use Lunkkun\Sudoku\Solver;

class BruteForceSolver extends BaseSolver implements Solver
{
    public function solve(): void
    {
        $row = $col = 0;
        $direction = 1;
        while ($row > -1 && $row < 9) {
            while ($col > -1 && $col < 9) {
                if ($this->original->get($row, $col) !== 0) {
                    $col += $direction;
                    continue;
                }
                $direction = 1;

                $value = $this->board->get($row, $col);

                $value++;
                while ($value <= 9) {
                    if ($this->board->try($row, $col, $value)) {
                        $this->board->set($row, $col, $value);
                        $col++;
                        continue 2;
                    }
                    $value++;
                }

                $this->board->clear($row, $col);
                $direction = -1;
                $col--;
            }

            if ($col === 9) {
                $col = 0;
                $row++;
                continue;
            }

            $col = 8;
            $row--;
        }
    }
}
