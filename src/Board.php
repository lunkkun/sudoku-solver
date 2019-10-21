<?php

namespace Lunkkun\Sudoku;

use Lunkkun\Sudoku\Exceptions\InvalidBoardException;

class Board
{
    /** @var int[][] */
    protected $rows;
    /** @var int[][] */
    protected $columns;
    /** @var int[][] */
    protected $boxes;

    public function __construct(array $rows)
    {
        $this->rows = $rows;
        $this->validate();
        $this->setColumns();
        $this->setBoxes();
    }

    public static function empty(): self
    {
        return new static(array_fill(0, 9, array_fill(0, 9, 0)));
    }

    private function validate(): void
    {
        if (!is_array($this->rows)) {
            throw new InvalidBoardException("Board is not an array");
        }

        if (count($this->rows) !== 9) {
            throw new InvalidBoardException("Board has incorrect amount of rows");
        }

        foreach ($this->rows as $index => &$row) {
            if (!is_array($row)) {
                throw new InvalidBoardException("Row $index is not an array");
            }

            if (count($row) !== 9) {
                throw new InvalidBoardException("Row $index has incorrect amount of entries");
            }

            foreach ($row as $position => $value) {
                if (!is_int($value)) {
                    throw new InvalidBoardException("Value at row $index, position $position is not an integer");
                }

                if (!in_array($value, range(0, 9))) {
                    throw new InvalidBoardException("Value at row $index, position $position is out of range");
                }
            }
        }
    }

    private function setColumns(): void
    {
        for ($col = 0; $col < 9; $col++) {
            $values = [];
            foreach ($this->rows as &$row) {
                $values[] = &$row[$col];
            }
            $this->columns[] = $values;
        }
    }

    private function setBoxes(): void
    {
        for ($i = 0; $i < 3; $i++) {
            for ($j = 0; $j < 3; $j++) {
                $box = [];
                for ($row = $i * 3; $row < $i * 3 + 3; $row++) {
                    $rowValues = &$this->rows[$row];
                    for ($col = $j * 3; $col < $j * 3 + 3; $col++) {
                        $box[] = &$rowValues[$col];
                    }
                }
                $this->boxes[] = $box;
            }
        }
    }

    public function get(int $row, int $col): int
    {
        return $this->rows[$row][$col];
    }

    public function set(int $row, int $col, int $value): void
    {
        $this->rows[$row][$col] = $value;
    }

    public function clear(int $row, int $col): void
    {
        $this->set($row, $col, 0);
    }

    public function try(int $row, int $col, int $value): bool
    {
        return $value === 0 || $value === $this->rows[$row][$col] || (
            $this->tryRow($row, $value) &&
            $this->tryColumn($col, $value) &&
            $this->tryBox($row, $col, $value)
        );
    }

    public function tryRow(int $row, int $value): bool
    {
        return !in_array($value, $this->rows[$row]);
    }

    public function tryColumn(int $col, int $value): bool
    {
        return !in_array($value, $this->columns[$col]);
    }

    public function tryBox(int $row, int $col, int $value): bool
    {
        return !in_array($value, $this->boxes[$this->getBoxAtPosition($row, $col)]);
    }

    public function isComplete(): bool
    {
        foreach ($this->rows as &$row) {
            foreach ($row as &$value) {
                if ($value === 0) {
                    return false;
                }
            }
        }

        return true;
    }

    public function isConsistent(): bool
    {
        for ($i = 0; $i < 9; $i++) {
            if (!$this->checkRow($i)) {
                return false;
            }

            if (!$this->checkColumn($i)) {
                return false;
            }

            if (!$this->checkBox($i)) {
                return false;
            }
        }

        return true;
    }

    public function isSolved(): bool
    {
        return $this->isComplete() && $this->isConsistent();
    }

    public function checkRow(int $row): bool
    {
        return $this->checkArray($this->rows[$row]);
    }

    public function checkColumn(int $col): bool
    {
        return $this->checkArray($this->columns[$col]);
    }

    public function checkBoxAtPosition(int $row, int $col): bool
    {
        return $this->checkBox($this->getBoxAtPosition($row, $col));
    }

    protected function getBoxAtPosition(int $row, int $col): int
    {
        return (int)floor($row / 3) * 3 + (int)floor($col / 3);
    }

    protected function checkBox(int $index): bool
    {
        return $this->checkArray($this->boxes[$index]);
    }

    protected function checkArray(array &$values): bool
    {
        $unique = [];
        foreach ($values as &$value) {
            if ($value !== 0) {
                if (in_array($value, $unique)) {
                    return false;
                }
                $unique[] = $value;
            }
        }

        return true;
    }

    public function __toString(): string
    {
        $string = '';

        foreach ($this->rows as &$row) {
            $string .= implode(' ', $row) . PHP_EOL;
        }

        return $string;
    }

    public function copy(): self
    {
        $board = static::empty();
        for ($row = 0; $row < 9; $row++) {
            for ($col = 0; $col < 9; $col++) {
                $board->set($row, $col, $this->get($row, $col));
            }
        }
        return $board;
    }
}
