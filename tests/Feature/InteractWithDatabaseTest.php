<?php

use OnurSimsek\LaravelExtended\Support\InteractsWithDatabase;
use Workbench\App\Models\User;
use Workbench\App\Models\UserSecond;

use function Orchestra\Testbench\workbench_path;

$class = new class () {
    use InteractsWithDatabase;

    public const FIRST_CONNECTION = 'testing';
    public const SECOND_CONNECTION = 'testing_second_db';
};

describe('interact with database', function () use ($class) {
    beforeEach(function () use ($class) {
        config()->set(
            key: sprintf('database.connections.%s', $class::SECOND_CONNECTION),
            value: config(sprintf('database.connections.%s', $class::FIRST_CONNECTION)),
        );

        $this->loadMigrationsFrom(workbench_path('database/migrations'));
    });

    /**
     * Commit tests
     */
    it('should be committed single database', function () use ($class) {
        $class->beginTransaction();
        User::factory()->count(5)->create();
        $class->commit();

        $this->assertDatabaseCount('users', 5);
    });

    it('should be commit multiple databases', function () use ($class) {
        $class->beginTransaction($class::FIRST_CONNECTION, $class::SECOND_CONNECTION);
        User::factory()->count(5)->create();
        UserSecond::factory()->count(5)->create();
        $class->commit($class::FIRST_CONNECTION, $class::SECOND_CONNECTION);

        $this->assertDatabaseCount('users', 5, $class::FIRST_CONNECTION);
        $this->assertDatabaseCount('users', 5, $class::SECOND_CONNECTION);
    });

    it('should be commit all multiple databases', function () use ($class) {
        $class->beginTransaction($class::FIRST_CONNECTION, $class::SECOND_CONNECTION);
        User::factory()->count(5)->create();
        UserSecond::factory()->count(5)->create();
        $class->commitAll();

        $this->assertDatabaseCount('users', 5, $class::FIRST_CONNECTION);
        $this->assertDatabaseCount('users', 5, $class::SECOND_CONNECTION);
    });

    /**
     * Rollback tests
     */
    it('should be rollback single database', function () use ($class) {
        $class->beginTransaction();
        User::factory()->count(5)->create();
        $class->rollBack();

        $this->assertDatabaseCount('users', 0);
    });

    it('should be rollback multiple databases', function () use ($class) {
        $class->beginTransaction($class::FIRST_CONNECTION, $class::SECOND_CONNECTION);
        User::factory()->count(5)->create();
        UserSecond::factory()->count(5)->create();
        $class->rollBack($class::FIRST_CONNECTION, $class::SECOND_CONNECTION);

        $this->assertDatabaseCount('users', 0, $class::FIRST_CONNECTION);
        $this->assertDatabaseCount('users', 0, $class::SECOND_CONNECTION);
    });

    it('should be rollback all multiple databases', function () use ($class) {
        $class->beginTransaction($class::FIRST_CONNECTION, $class::SECOND_CONNECTION);
        User::factory()->count(5)->create();
        UserSecond::factory()->count(5)->create();
        $class->rollBackAll();

        $this->assertDatabaseCount('users', 0, $class::FIRST_CONNECTION);
        $this->assertDatabaseCount('users', 0, $class::SECOND_CONNECTION);
    });
});
