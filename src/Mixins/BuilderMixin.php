<?php

namespace OnurSimsek\LaravelExtended\Mixins;

use Illuminate\Database\Query\Builder;
use OnurSimsek\LaravelExtended\DatabaseQueryBuilder\BoundaryConstraints;
use OnurSimsek\LaravelExtended\DatabaseQueryBuilder\ConditionalConstraints;

/**
 * @mixin Builder
 */
class BuilderMixin
{
    use BoundaryConstraints;
    use ConditionalConstraints;
}
