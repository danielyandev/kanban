<?php

namespace Database\Factories;

use App\Models\State;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Task::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $user = User::factory()->create();
        $state = State::factory()->create();
        return [
            'name' => $this->faker->name,
            'user_id' => $user->id,
            'state_id' => $state->id,
            'priority' => 0,
        ];
    }
}
