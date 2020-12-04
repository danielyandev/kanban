<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'state_id' => 'required|integer',
            'deadline' => 'nullable|date',
            'assigned_user_id' => 'nullable|integer',
            'priority' => 'required|in:'. implode(',', array_keys(Task::$priorities))
        ];
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), $this->rules());
        if ($validator->fails()){
            return $this->errorResponse([
                'errors' => $validator->errors()
            ]);
        }

        $task = new Task();
        $task->fill($request->only($task->getFillable()));
        $task->user_id = Auth::id();
        $task->save();

        return $this->successResponse(compact('task'));

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Task $task)
    {
        return $this->successResponse(compact('task'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Task $task)
    {
        $validator = Validator::make($request->all(), $this->rules());
        if ($validator->fails()){
            return $this->errorResponse([
                'errors' => $validator->errors()
            ]);
        }

        $task->fill($request->only($task->getFillable()));
        $task->save();

        return $this->successResponse(compact('task'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Task $task)
    {
        $task->delete();
        return $this->successResponse([
            'message' => 'Task was successfully deleted'
        ]);
    }
}
