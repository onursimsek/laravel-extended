<?php

namespace OnurSimsek\LaravelExtended\Mixins;

use Closure;
use Illuminate\Support\Str;
use Illuminate\Support\Stringable;

/**
 * @mixin Stringable
 */
class StringableMixin
{
    public function squishBetween(): Closure
    {
        return fn (string $from, string $to): Stringable => new static(Str::squishBetween($this->value, $from, $to));
    }

    public function replaceBetweenMatch(): Closure
    {
        /** @phpstan-ignore-next-line */
        return fn (string $from, string $to, string $search, string $replace): Stringable => new static(
            Str::replaceBetweenMatch($this->value, $from, $to, $search, $replace)
        );
    }

    public function replaceBetween(): Closure
    {
        /** @phpstan-ignore-next-line */
        return fn (string $from, string $to, string $search, string $replace): Stringable => new static(
            Str::replaceBetween($this->value, $from, $to, $search, $replace)
        );
    }
}
