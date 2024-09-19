<?php

namespace OnurSimsek\LaravelExtended\Support\Enums;

/**
 * @mixin \BackedEnum
 */
trait HasValue
{
    use HasName;

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
