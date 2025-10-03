<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DatabaseTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_connect_to_the_database()
    {
        $this->assertTrue(DB::connection()->getPdo() instanceof \PDO);
    }

    /** @test */
    public function it_can_access_users_table()
    {
        // This will throw an exception if the table doesn't exist
        $users = DB::table('users')->count();
        $this->assertIsInt($users);
    }

    /** @test */
    public function it_can_create_a_user()
    {
        $user = User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
            'role' => 'customer'
        ]);

        $this->assertDatabaseHas('users', [
            'email' => 'test@example.com',
            'name' => 'Test User'
        ]);
    }
}
