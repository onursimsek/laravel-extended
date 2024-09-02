<?php

namespace LaravelExtended\LaravelExtended;

use Illuminate\Foundation\Console\AboutCommand;
use Illuminate\Support\AggregateServiceProvider;

final class LaravelExtendedServiceProvider extends AggregateServiceProvider
{
    private const CONFIG_FILE = 'extended.php';

    private const CONFIG_KEY = 'extended';

    private const CONFIG_PATH = __DIR__.'/../config/'.self::CONFIG_FILE;

    public function boot(): void
    {
        AboutCommand::add('Laravel Extended', fn () => ['Version' => '1.0.0']);

        if ($this->app->runningInConsole()) {
            $this->publishing();
        }
    }

    public function register(): void
    {
        $this->mergeConfigFrom(self::CONFIG_PATH, self::CONFIG_KEY);
    }

    private function publishing(): void
    {
        $this->publishes([self::CONFIG_PATH => config_path(self::CONFIG_FILE)], self::CONFIG_KEY);
    }
}
