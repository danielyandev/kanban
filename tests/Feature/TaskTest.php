<?php

namespace Tests\Feature;

use App\Models\State;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TaskTest extends TestCase
{
    protected function user()
    {
        return User::factory()->create();
    }
    /**
     * Create new task
     *
     * @return void
     */
    public function testCreateTask()
    {
        $state = State::factory()->create();
        $data = [
            'name' => 'Test name',
            'state_id' => $state->id,
            'priority' => 0,
        ];
        $response = $this->actingAs($this->user(), 'api')->postJson('/api/tasks', $data);

        $response
            ->assertStatus(200)
            ->assertJson([
                'success' => true
            ]);
    }

    /**
     * Create a state and a task, move task to another state
     *
     * @return void
     */
    public function testUpdateTask()
    {
        $state = State::factory()->create();
        $task = Task::factory()->create();

        $uri = '/api/tasks/'. $task->id;
        $data = [
            'state_id' => $state->id,
        ];
        $response = $this->actingAs($this->user(), 'api')->putJson($uri, $data);

        $response
            ->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data' => [
                    'task' => [
                        'state_id' => $state->id
                    ]
                ]
            ]);
    }

    /**
     * Delete task
     *
     * @return void
     */
    public function testDeleteTask()
    {
        $task = Task::factory()->create();

        $uri = '/api/tasks/'. $task->id;
        $response = $this->actingAs($this->user(), 'api')->deleteJson($uri);

        $response
            ->assertStatus(200)
            ->assertJson([
                'success' => true,
            ]);

        // check in db
        $exists = Task::where('id', $task->id)->exists();
        $this->assertFalse($exists);
    }
}
