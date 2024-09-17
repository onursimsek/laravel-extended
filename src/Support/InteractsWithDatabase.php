<?php

namespace OnurSimsek\LaravelExtended\Support;

use Illuminate\Support\Facades\DB;

trait InteractsWithDatabase
{
    private array $connections = [];

    public function beginTransaction(string ...$connections): void
    {
        $this->connections = $connections ?: [$this->defaultConnection()];
        $this->execute('beginTransaction', $this->connections);
    }

    public function commit(string ...$connections): void
    {
        $this->execute('commit', $connections);
    }

    public function commitAll(): void
    {
        $this->execute('commit', $this->connections);
    }

    public function rollBack(string ...$connections): void
    {
        $this->execute('rollBack', $connections);
    }

    public function rollBackAll(): void
    {
        $this->execute('rollBack', $this->connections);
    }

    private function defaultConnection()
    {
        return config('database.default');
    }

    private function execute(string $method, array $connections): void
    {
        foreach ($connections ?: [$this->defaultConnection()] as $connection) {
            DB::connection($connection)->$method();
        }
    }
}
