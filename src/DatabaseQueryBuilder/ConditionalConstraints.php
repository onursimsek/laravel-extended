<?php

namespace OnurSimsek\LaravelExtended\DatabaseQueryBuilder;

use Closure;
use Illuminate\Database\Query\Builder;

/**
 * @mixin Builder
 */
trait ConditionalConstraints
{
    public function whenWhere(): Closure
    {
        return function ($value, string $column) {
            return $this->when($value, fn () => $this->where($column, $value));
        };
    }
}
