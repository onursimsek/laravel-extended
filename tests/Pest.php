<?php

declare(strict_types=1);

use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use OnurSimsek\LaravelExtended\Tests\TestCase;

uses(TestCase::class, LazilyRefreshDatabase::class)->in('Unit', 'Feature');
