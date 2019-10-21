<?php

namespace Lunkkun\Sudoku\Solvers\Permutations;

use Generator;
use Iterator;

class CachedGenerator implements Iterator
{
    /** @var Iterator */
    protected $generator;
    /** @var array */
    protected $cache = [];

    public function __construct(Generator $generator)
    {
        $this->generator = $generator;
        $this->addCurrentToCache();
    }

    public function current()
    {
        return current($this->cache);
    }

    public function next(): void
    {
        if ($this->generator->key() === key($this->cache)) {
            $this->generator->next();
            $this->addCurrentToCache();
        }
        next($this->cache);
    }

    public function key(): int
    {
        return key($this->cache);
    }

    public function valid(): bool
    {
        return key($this->cache) !== null;
    }

    public function rewind(): void
    {
        reset($this->cache);
    }

    protected function addCurrentToCache(): void
    {
        if ($this->generator->valid()) {
            $this->cache[] = $this->generator->current();
        }
    }
}
