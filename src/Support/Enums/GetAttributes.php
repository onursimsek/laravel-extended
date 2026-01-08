<?php

declare(strict_types=1);

namespace OnurSimsek\LaravelExtended\Support\Enums;

use BackedEnum;
use Illuminate\Support\Str;
use ReflectionAttribute;
use UnitEnum;

/**
 * @mixin UnitEnum|BackedEnum
 */
trait GetAttributes
{
    private const ATTRIBUTES_NAMESPACE = 'App\\Enums\\Concerns\\';

    public function __call(string $name, array $arguments)
    {
        $classes = $this->getAttributeClasses($name);
        if (count($classes) === 0) {
            return Str::headline($this?->value ?? $this->name);
        }

        return $classes[0]->newInstance()->getValue();
    }

    /**
     * @return ReflectionAttribute[]
     */
    private function getAttributeClasses(string $class): array
    {
        return (new \ReflectionClassConstant($this, $this->name))
            ->getAttributes(self::ATTRIBUTES_NAMESPACE . Str::studly($class));
    }
}
