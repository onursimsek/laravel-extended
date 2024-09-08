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

    private const GREATER_THAN_OR_EQUAL = '>=';

    private const LESS = '<';

    private const LESS_THAN_OR_EQUAL = '<=';

    public function whereGreaterThan(): Closure
    {
        return $this->whereClosure(self::GREATER);
    }

    public function whereGreaterThanOrEqual(): Closure
    {
        return $this->whereClosure(self::GREATER_THAN_OR_EQUAL);
    }

    public function whereLessThan(): Closure
    {
        return $this->whereClosure(self::LESS);
    }

    public function whereLessThanOrEqual(): Closure
    {
        return $this->whereClosure(self::LESS_THAN_OR_EQUAL);
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

    public function whereColumnGreaterThanOrEqual(): Closure
    {
        return $this->whereColumnClosure(self::GREATER_THAN_OR_EQUAL);
    }

    public function whereColumnLessThan(): Closure
    {
        return $this->whereColumnClosure(self::LESS);
    }

    public function whereColumnLessThanOrEqual(): Closure
    {
        return $this->whereColumnClosure(self::LESS_THAN_OR_EQUAL);
    }

    private function whereColumnClosure(string $operator): \Closure
    {
        return function (string $first, string $second) use ($operator) {
            return $this->whereColumn($first, $operator, $second);
        };
    }
}
