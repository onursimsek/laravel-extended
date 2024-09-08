<?php

namespace OnurSimsek\LaravelExtended\Mixins;

use Closure;
use Illuminate\Support\Str;
use OnurSimsek\LaravelExtended\Support\CallInClosure;

/**
 * @mixin Str
 */
class StrMixin
{
    use CallInClosure;

    public function squishBetween(): Closure
    {
        $between = $this->callInClosure('between');
        $before = $this->callInClosure('before');
        $after = $this->callInClosure('after');

        return function (string $str, string $from, string $to) use ($between, $before, $after) {
            return $before($str, $from) . self::squish($between($str, $from, $to)) . $after($str, $to);
        };
    }

    public function replaceBetweenMatch(): Closure
    {
        $between = $this->callInClosure('between');
        $before = $this->callInClosure('before');
        $after = $this->callInClosure('after');

        return function (string $str, string $from, string $to, string $pattern, string $replace) use ($between, $before, $after) {
            $target = $between($str, $from, $to);

            return $before($str, $from) . preg_replace($pattern, $replace, $target) . $after($str, $to);
        };
    }

    public function replaceBetween(): Closure
    {
        $between = $this->callInClosure('between');
        $before = $this->callInClosure('before');
        $after = $this->callInClosure('after');

        return function (string $str, string $from, string $to, string $search, string $replace) use ($between, $before, $after) {
            $target = $between($str, $from, $to);

            return $before($str, $from) . str_replace($search, $replace, $target) . $after($str, $to);
        };
    }

    private function fromPosition(string $str, string $from): false|int
    {
        return mb_strpos($str, $from);
    }

    private function toPosition(string $str, string $to): false|int
    {
        return mb_strrpos($str, $to);
    }

    private function before(string $str, string $from): string
    {
        return mb_substr($str, 0, $this->fromPosition($str, $from));
    }

    private function after(string $str, string $to): string
    {
        return mb_substr($str, $this->toPosition($str, $to) + mb_strlen($to));
    }

    private function between(string $str, string $from, string $to): string
    {
        $fromPosition = $this->fromPosition($str, $from);

        return mb_substr($str, $fromPosition, $this->toPosition($str, $to) - $fromPosition + mb_strlen($to));
    }
}
