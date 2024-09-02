<?php

namespace OnurSimsek\LaravelExtended\Tests;

use OnurSimsek\LaravelExtended\LaravelExtendedServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app): array
    {
        return [
            LaravelExtendedServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app): void
    {
        //
    }
}
