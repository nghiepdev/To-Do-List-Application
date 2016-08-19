<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TodoRequest;
use App\Models\Todo;

class TodoController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth:api');
    }

    public function index()
    {
        return $this->user->todos()->latest()->get();
    }

    public function store(TodoRequest $request)
    {
        $todo = new Todo($request->only(['name', 'completed']));
        $todo->user()->associate($this->user);
        $todo->save();
        return $todo;
    }

    public function update(Todo $todo, TodoRequest $request)
    {
        $this->authorize('update-and-delete', $todo);
        $todo->update($request->only(['name', 'completed']));
        return $this->responseSuccess();
    }

    public function destroy(Todo $todo)
    {
        $this->authorize('update-and-delete', $todo);
        $todo->delete();
        return $this->responseSuccess();
    }

    private function responseSuccess($message = 'success', $status = 200)
    {
        return response()->json(['message' => $message], $status);
    }
}
