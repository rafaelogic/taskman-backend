<?php

namespace Tests;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();

        $this->setupDatabase('testing');
    }

    protected function setupDatabase(string $databaseName): void
    {
        $query  = 'SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME =  ?';
        $db     = DB::select($query, [$databaseName]);

        if (empty($db)) {
            DB::statement('create database `'. $databaseName. '`');
        }

        if (! Schema::hasTable('user')) {
            $this->artisan('migrate');
        }
    }

    protected function tearDown(): void
    {
        DB::connection('mysql')->rollBack(DB::transactionLevel() - 1);
    }
}
