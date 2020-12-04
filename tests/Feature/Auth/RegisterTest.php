<?php

namespace Tests\Feature\Auth;

use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterTest extends TestCase
{

    public function testUserCanRegister()
    {
        $data = [
            'name' => 'Test name',
            'email' => Carbon::now()->timestamp . '_testmail@mail.com',
            'password' => 'testpassword',
            'password_confirmation' => 'testpassword',
        ];
        $response = $this->postJson('/api/register', $data);

        $response
            ->assertStatus(200)
            ->assertJson([
                'success' => true
            ]);
    }

    public function testUserCanNotRegister()
    {
        $data = [
            'name' => 'Test name',
            'email' => 'sometestmail@mail.com',
            'password' => 'testpassword',
            'password_confirmation' => 'wrongconfirmation',
        ];
        $response = $this->postJson('/api/register', $data);

        $response
            ->assertStatus(200)
            ->assertJson([
                'success' => false
            ]);
    }


}
