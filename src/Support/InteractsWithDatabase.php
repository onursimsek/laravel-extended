<?php

namespace OnurSimsek\LaravelExtended\Support;

use Illuminate\Support\Facades\DB;

trait InteractsWithDatabase
{
    private array $connections = [];

    public function beginTransaction(string ...$connections): void
    {
        $this->connections = $connections ?: [$this->defaultConnection()];
        foreach ($this->connections as $connection) {
            DB::connection($connection)->beginTransaction();
        }
    }

    public function commit(string ...$connections): void
    {
        foreach ($connections ?: [$this->defaultConnection()] as $connection) {
            DB::connection($connection)->commit();
        }
    }

    public function commitAll(): void
    {
        $this->commit(...$this->connections);
    }

    public function rollBack(string ...$connections): void
    {
        foreach ($connections ?: [$this->defaultConnection()] as $connection) {
            DB::connection($connection)->rollBack();
        }
    }

    public function rollBackAll(): void
    {
        $this->rollBack(...$this->connections);
    }

    private function defaultConnection()
    {
        return config('database.default');
    }
}
