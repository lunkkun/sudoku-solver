<?php

namespace Lunkkun\Sudoku\Tests;

use Lunkkun\Sudoku\Solvers\Permutations\CachedGenerator;
use PHPUnit\Framework\TestCase;

class CachedGeneratorTest extends TestCase
{
    public function testGenerates() {
        $generator = function () {
            foreach (range(0, 3) as $value) {
                yield $value;
            }
        };
        $cachedGenerator = new CachedGenerator($generator());

        $results = [];
        foreach ($cachedGenerator as $value) {
            $results[] = $value;
        }
        $this->assertEquals(range(0, 3), $results);
    }

    public function testWorksWithEmptyGenerator() {
        $generator = function () {
            if (false) yield 0;
        };
        $cachedGenerator = new CachedGenerator($generator());

        $results = [];
        foreach ($cachedGenerator as $value) {
            $results[] = $value;
        }
        $this->assertEquals([], $results);
    }

    public function testWorksTwice() {
        $generator = function () {
            foreach (range(0, 3) as $value) {
                yield $value;
            }
        };
        $cachedGenerator = new CachedGenerator($generator());

        foreach ($cachedGenerator as $value) {}

        $results = [];
        foreach ($cachedGenerator as $value) {
            $results[] = $value;
        }
        $this->assertEquals(range(0, 3), $results);
    }
}
