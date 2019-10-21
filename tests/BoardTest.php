<?php

namespace Lunkkun\Sudoku\Tests;

use PHPUnit\Framework\TestCase;
use Lunkkun\Sudoku\Board;

class BoardTest extends TestCase
{
    public function testValidatesBoard(): void
    {
        $rows = include(__DIR__ . '/../data/test/invalid.php');
        try {
            $board = new Board($rows);
        } catch (\Exception $e) {
            $board = null;
        }
        $this->assertNull($board);
    }

    public function testLoadsBoard(): void
    {
        $rows = include(__DIR__ . '/../data/test/puzzle.php');
        $board = new Board($rows);
        $this->assertInstanceOf(Board::class, $board);
    }

    public function testValidEmptyBoard(): void
    {
        $board = Board::empty();
        $this->assertInstanceOf(Board::class, $board);
    }

    public function testChecksRow(): void
    {
        $rows = include(__DIR__ . '/../data/test/puzzle.php');
        $board = new Board($rows);
        $this->assertTrue($board->checkRow(0));

        $board->set(0, 0, 6);
        $this->assertFalse($board->checkRow(0));
    }

    public function testChecksColumn(): void
    {
        $rows = include(__DIR__ . '/../data/test/puzzle.php');
        $board = new Board($rows);
        $this->assertTrue($board->checkColumn(0));

        $board->set(0, 0, 7);
        $this->assertFalse($board->checkColumn(0));
    }

    public function testChecksBox(): void
    {
        $rows = include(__DIR__ . '/../data/test/puzzle.php');
        $board = new Board($rows);
        $this->assertTrue($board->checkBoxAtPosition(0, 0));

        $board->set(0, 0, 6);
        $this->assertFalse($board->checkBoxAtPosition(0, 0));
    }

    public function testChecksComplete(): void
    {
        $rows = include(__DIR__ . '/../data/test/solved.php');
        $board = new Board($rows);
        $this->assertTrue($board->isComplete());

        $board->clear(0, 0);
        $this->assertFalse($board->isComplete());
    }

    public function testChecksSolved(): void
    {
        $rows = include(__DIR__ . '/../data/test/solved.php');
        $board = new Board($rows);
        $this->assertTrue($board->isSolved());

        $board->clear(0, 0);
        $this->assertFalse($board->isSolved());
    }

    public function testTries(): void
    {
        $rows = include(__DIR__ . '/../data/test/puzzle.php');
        $board = new Board($rows);

        $this->assertTrue($board->try(0, 0, 1));
        $this->assertTrue($board->try(0, 1, 0));
        $this->assertTrue($board->try(0, 1, 2));

        $this->assertFalse($board->try(0, 1, 6));
        $this->assertFalse($board->try(0, 1, 4));
        $this->assertFalse($board->try(0, 1, 7));
    }

    public function testCopiesCorrectly(): void
    {
        $board = Board::empty();
        $board2 = $board->copy();
        $board->set(0, 0, 1);
        $this->assertEquals(0, $board2->get(0, 0));
    }
}
