<?php

namespace Tests\Feature;

use App\Models\State;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StateTest extends TestCase
{

   protected function user()
   {
       return User::factory()->create();
   }

    /**
     * Create new state
     *
     * @return void
     */
    public function testCreateState()
    {
        $data = [
            'name' => 'State test name'
        ];
        $response = $this->actingAs($this->user(), 'api')->postJson('/api/states', $data);

        $response
            ->assertStatus(200)
            ->assertJson([
                'success' => true
            ]);
    }

    /**
     * Create 2 states and move second to the beginning
     *
     * @return void
     */
    public function testUpdateState()
    {
        $state1 = State::factory()->create();
        $state2 = State::factory()->create();

        $uri = '/api/states/'. $state2->id;
        $data = [
            'order' => 0
        ];
        $response = $this->actingAs($this->user(), 'api')->putJson($uri, $data);

        $response
            ->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data' => [
                    'state' => [
                        'order' => 0
                    ]
                ]
            ]);
    }

    /**
     * Delete state
     *
     * @return void
     */
    public function testDeleteState()
    {
        $state = State::factory()->create();

        $uri = '/api/states/'. $state->id;
        $response = $this->actingAs($this->user(), 'api')->deleteJson($uri);

        $response
            ->assertStatus(200)
            ->assertJson([
                'success' => true,
            ]);

        // check in db
        $exists = State::where('id', $state->id)->exists();
        $this->assertFalse($exists);
    }
}
