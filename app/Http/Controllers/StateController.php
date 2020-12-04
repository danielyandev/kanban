<?php

namespace App\Http\Controllers;

use App\Models\State;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $states = State::ordered()->with('tasks')->get();
        return $this->successResponse(compact('states'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:255'
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()){
            return $this->errorResponse([
                'errors' => $validator->errors()
            ]);
        }

        $state = State::create([
            'name' => $request->name,
            'order' => State::count()
        ]);

        return $this->successResponse(compact('state'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\State  $state
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, State $state)
    {
        $rules = [
            'name' => 'nullable|string|max:255',
            'order' => 'required|integer'
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()){
            return $this->errorResponse([
                'errors' => $validator->errors()
            ]);
        }

        // state was moved from left to right
        // decrement orders from left
        if ($request->order > $state->order){
            State::where('id', '!=', $state->id)
                ->where('order', '>', $state->order)
                ->where('order', '<=', $request->order)
                ->decrement('order');
        }
        // state was moved from right to left
        // increment orders from right
        else if ($request->order < $state->order){
            State::where('id', '!=', $state->id)
                ->where('order', '<', $state->order)
                ->where('order', '>=', $request->order)
                ->increment('order');
        }

        $state->order = $request->order;
        if ($request->name){
            $state->name = $request->name;
        }

        $state->save();

        return $this->successResponse(compact('state'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\State  $state
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(State $state)
    {
        $state->tasks()->delete();
        $state->delete();

        return $this->successResponse([
            'message' => 'State was successfully deleted'
        ]);
    }
}
