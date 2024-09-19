<?php

namespace OnurSimsek\LaravelExtended\Support\Enums;

/**
 * @mixin \UnitEnum
 */
trait HasName
{
    public static function names(): array
    {
        return array_column(self::cases(), 'name');
    }
}
