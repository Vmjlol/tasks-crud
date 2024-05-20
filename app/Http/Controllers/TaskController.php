<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
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
        // Maneira certa com condições, porém o front-end não me ajudou
        $tasks = Task::with('subtasks')->get();
        $tasksToday = Task::with('subtasks')->whereDate('due_date', Carbon::now()->toDateString())->get();
        $tasksLate = Task::with('subtasks')->whereDate('due_date', '<', Carbon::now()->toDateString())->get();

        $taskDate = $request->input('taskDate');

        if ($taskDate == 'today') {
            $option = ['tasksToday' => $tasksToday];
        } elseif ($taskDate == 'late') {
            $option = ['tasksLate' => $tasksLate];
        } else {
            $option = [
                'tasks' => $tasks,
            ];
        }
        return response()->json($option);
    }

    // Muitas funções, mas acabou dando certo
    public function today()
    {
        $tasksToday = Task::with('subtasks')->whereDate('due_date', Carbon::now()->toDateString())->get();
        return response()->json($tasksToday);
    }

    public function late()
    {
        $tasksLate = Task::with('subtasks')->whereDate('due_date', '<', Carbon::now()->toDateString())->get();
        return response()->json($tasksLate);
    }

    public function create(Request $request)
    {

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

        $task = Task::create($request->input());

        return response()->json([
            'message' => 'Task created',
            'task' => $task
        ], 201);
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
            'message' => 'Task updated',
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

        $task->update(['status' => $request->input('status')]);
        $task->subtasks()->update(['status' => $request->input('status')]);

        return response()->json([
            'message' => 'Status updated',
            'task' => $task
        ]);
    }

    public function destroy(Task $task)
    {
        $task->delete();
        return response()->json([
            'message' => 'Task deleted'
        ]);
    }
}
