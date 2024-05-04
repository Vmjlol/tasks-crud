<?php

namespace App\Http\Controllers;

use App\Models\Subtask;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{

    public function __invoke()
    {
    }

    public function index(Request $request)
    {
        return response()->json(Task::with('subtasks')->paginate($request->input('per_page') ?? 10));
    }

    public function create(Request $request)
    {
        return Task::create($request->input());

        $validation = Validator::make(
            $request->all(),
            [
                'title' => 'required',
                'description' => 'required',
                'due_date' => 'required'
            ],
            [
                'title.required' => 'Insira um título',
                'description.required' => 'Insira uma descrição',
                'due_date.required' => 'Insira uma data',
            ]
        );

        if ($validation->fails()) {
            return response()->json($validation->errors(), 422);
        }

        return response()->json([
            'message' => 'Success'
        ]);
    }

    public function show(Task $task)
    {
        return response()->json($task);
    }

    public function update(Request $request, Task $task)
    {
        $validation = Validator::make(
            $request->all(),
            [
                'title' => 'required',
                'description' => 'required'
            ],
            [
                'title.required' => 'Insira um título',
                'description.required' => 'Insira uma descrição'
            ]
        );

        if ($validation->fails()) {
            return response()->json($validation->errors(), 422);
        }

        $task->fill($request->input())->update();
        return response()->json([
            'message' => 'Updated',
            'task' => $task
        ]);
    }

    public function updateStatus(Request $request, Task $task)
    {
        $validation = Validator::make(
            $request->all(),
            [
                'status' => 'required'
            ],
            [
                'status.required' => 'Insira uma status'
            ]
        );

        if ($validation->fails()) {
            return response()->json($validation->errors(), 422);
        }

        $task->fill($request->input())->update();

        return response()->json([
            'message' => 'Updated',
            'task' => $task
        ]);
    }

    public function destroy(Task $task)
    {
        $task->delete();
        return response()->json([
            'message' => 'Deleted!'
        ]);
    }
}
