<?php

use OnurSimsek\LaravelExtended\Support\InteractsWithDatabase;
use Workbench\App\Models\User;
use Workbench\App\Models\UserSecond;

use function Orchestra\Testbench\workbench_path;

describe('interact with database', function () {
    beforeEach(function () {
        $this->class = new class () {
            use InteractsWithDatabase;

            public const FIRST_CONNECTION = 'testing';

            public const SECOND_CONNECTION = 'testing_second_db';
        };

        config()->set(
            key: sprintf('database.connections.%s', $this->class::SECOND_CONNECTION),
            value: config(sprintf('database.connections.%s', $this->class::FIRST_CONNECTION)),
        );

        $this->loadMigrationsFrom(workbench_path('database/migrations'));
    });

    /**
     * Commit tests
     */
    it('should be committed single database', function () {
        $this->class->beginTransaction();
        User::factory()->count(5)->create();
        $this->class->commit();

        $this->assertDatabaseCount('users', 5);
    });

    it('should be commit multiple databases', function () {
        $this->class->beginTransaction($this->class::FIRST_CONNECTION, $this->class::SECOND_CONNECTION);
        User::factory()->count(5)->create();
        UserSecond::factory()->count(5)->create();
        $this->class->commit($this->class::FIRST_CONNECTION, $this->class::SECOND_CONNECTION);

        $this->assertDatabaseCount('users', 5, $this->class::FIRST_CONNECTION);
        $this->assertDatabaseCount('users', 5, $this->class::SECOND_CONNECTION);
    });

    it('should be commit all multiple databases', function () {
        $this->class->beginTransaction($this->class::FIRST_CONNECTION, $this->class::SECOND_CONNECTION);
        User::factory()->count(5)->create();
        UserSecond::factory()->count(5)->create();
        $this->class->commitAll();

        $this->assertDatabaseCount('users', 5, $this->class::FIRST_CONNECTION);
        $this->assertDatabaseCount('users', 5, $this->class::SECOND_CONNECTION);
    });

    /**
     * Rollback tests
     */
    it('should be rollback single database', function () {
        $this->class->beginTransaction();
        User::factory()->count(5)->create();
        $this->class->rollBack();

        $this->assertDatabaseCount('users', 0);
    });

    it('should be rollback multiple databases', function () {
        $this->class->beginTransaction($this->class::FIRST_CONNECTION, $this->class::SECOND_CONNECTION);
        User::factory()->count(5)->create();
        UserSecond::factory()->count(5)->create();
        $this->class->rollBack($this->class::FIRST_CONNECTION, $this->class::SECOND_CONNECTION);

        $this->assertDatabaseCount('users', 0, $this->class::FIRST_CONNECTION);
        $this->assertDatabaseCount('users', 0, $this->class::SECOND_CONNECTION);
    });

    it('should be rollback all multiple databases', function () {
        $this->class->beginTransaction($this->class::FIRST_CONNECTION, $this->class::SECOND_CONNECTION);
        User::factory()->count(5)->create();
        UserSecond::factory()->count(5)->create();
        $this->class->rollBackAll();

        $this->assertDatabaseCount('users', 0, $this->class::FIRST_CONNECTION);
        $this->assertDatabaseCount('users', 0, $this->class::SECOND_CONNECTION);
    });
});
