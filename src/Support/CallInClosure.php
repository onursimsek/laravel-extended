<?php

namespace OnurSimsek\LaravelExtended\Support;

use Closure;

trait CallInClosure
{
    private function callInClosure(string $method): Closure
    {
        if (! method_exists($this, $method)) {
            throw new \InvalidArgumentException();
        }

        return fn (...$args) => $this->$method(...$args);
    }
}
