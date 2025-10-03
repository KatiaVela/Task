<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function setUp(): void
    {
        parent::setUp();
        
        // This will run migrations for the test database
        $this->artisan('migrate');
        
        // If you're using SQLite, you might need to enable foreign key constraints
        if (config('database.default') === 'sqlite') {
            \DB::statement('PRAGMA foreign_keys=on;');
        }
    }
}