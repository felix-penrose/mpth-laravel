<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public User $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('passport:install');
    }

    public function loginUser()
    {
        $this->user = User::factory()->create([
            'password' => bcrypt($password = 'password'),
        ]);

        $this->actingAs($this->user, 'api');

        $response = $this->post('/api/login', [
            'email' => $this->user->email,
            'password' => $password,
        ]);

        $response->assertSuccessful();
        $response->assertJsonStructure([
            'token_type',
            'expires_in',
            'access_token',
            'refresh_token',
        ]);

        $this->assertAuthenticatedAs($this->user);
    }
}
