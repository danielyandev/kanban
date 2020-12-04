<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{
    /**
     * Login with valid credentials
     *
     * @return void
     */
    public function testUserCanLogin()
    {
        $user = User::factory()->create();

        $data = [
            'email' => $user->email,
            'password' => 'password'
        ];
        $response = $this->postJson('/api/login', $data);

        $response
            ->assertStatus(200)
            ->assertJson([
                'success' => true
            ]);
    }

    /**
     * Login with invalid credentials
     *
     * @return void
     */
    public function testUserCanNotLogin()
    {
        $data = [
            'email' => 'invalid_email',
            'password' => 'pass'
        ];
        $response = $this->postJson('/api/login', $data);

        $response
            ->assertStatus(200)
            ->assertJson([
                'success' => false
            ]);
    }
}
