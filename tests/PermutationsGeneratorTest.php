<?php

namespace Lunkkun\Sudoku\Tests;

use Lunkkun\Sudoku\Solvers\Permutations\PermutationsGenerator;
use PHPUnit\Framework\TestCase;

class PermutationsGeneratorTest extends TestCase
{
    public function testGeneratesPermutations() {
        $generator = new PermutationsGenerator(range(0, 2));

        $results = [];
        foreach ($generator as $value) {
            $results[] = $value;
        }
        sort($results);

        $this->assertEquals([
            [0, 1, 2],
            [0, 2, 1],
            [1, 0, 2],
            [1, 2, 0],
            [2, 0, 1],
            [2, 1, 0],
        ], $results);
    }

    public function testWorksWithEmptyArray() {
        $generator = new PermutationsGenerator([]);

        $results = [];
        foreach ($generator as $value) {
            $results[] = $value;
        }

        $this->assertEquals([], $results);
    }
}
