<?php

namespace OnurSimsek\LaravelExtended\DatabaseQueryBuilder;

use Closure;
use Illuminate\Database\Query\Builder;

/**
 * @mixin Builder
 */
trait BoundaryConstraints
{
    private const GREATER = '>';

    private const GREATER_OR_EQUAL = '>=';

    private const LESS = '<';

    private const LESS_OR_EQUAL = '<=';

    public function whereGreaterThan(): Closure
    {
        return $this->whereClosure(self::GREATER);
    }

    public function whereGT(): Closure
    {
        return $this->whereGreaterThan();
    }

    public function whereGreaterThanEqual(): Closure
    {
        return $this->whereClosure(self::GREATER_OR_EQUAL);
    }

    public function whereGTE(): Closure
    {
        return $this->whereGreaterThanEqual();
    }

    public function whereLessThan(): Closure
    {
        return $this->whereClosure(self::LESS);
    }

    public function whereLT(): Closure
    {
        return $this->whereLessThan();
    }

    public function whereLessThanEqual(): Closure
    {
        return $this->whereClosure(self::LESS_OR_EQUAL);
    }

    public function whereLTE(): Closure
    {
        return $this->whereLessThanEqual();
    }

    private function whereClosure(string $operator): Closure
    {
        return function (string $column, $value) use ($operator) {
            return $this->where($column, $operator, $value);
        };
    }

    public function whereColumnGreaterThan(): Closure
    {
        return $this->whereColumnClosure(self::GREATER);
    }

    public function whereColumnGT(): Closure
    {
        return $this->whereColumnGreaterThan();
    }

    public function whereColumnLessThan(): Closure
    {
        return $this->whereColumnClosure(self::LESS);
    }

    private function whereColumnClosure(string $operator): \Closure
    {
        return function (string $first, string $second) use ($operator) {
            return $this->whereColumn($first, $operator, $second);
        };
    }
}
