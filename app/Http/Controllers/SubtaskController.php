<?php

namespace App\Http\Controllers;

use App\Models\Subtask;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SubtaskController extends Controller
{

    public function __invoke()
    {
    }

    public function index()
    {
        return response()->json(Subtask::get());
    }

    public function create(Request $request)
    {
        
        $validation = Validator::make(
            $request->all(),
            [
                'description' => 'required',
                'task_id' => 'required'
            ],
            [
                'description.required' => 'Insira uma descrição',
                'task_id.required' => 'Insira uma ID da task principal',
            ]
        );

        if ($validation->fails()) {
            return response()->json($validation->errors(), 422);
        } 
            Subtask::create($request->input());
        
            $subtask = Subtask::create($request->input());
        

        return response()->json([
            'message' => 'Subtask created',
            'task' => $subtask
        ], 201);
    }

    public function show(Subtask $subtask)
    {
        return response()->json($subtask);
    }

    public function update(Request $request, Subtask $subtask)
    {
        $validation = Validator::make(
            $request->all(),
            [
                'description' => 'required',
            ],
            [
                'description.required' => 'Insira uma descrição',
            ]
        );

        if ($validation->fails()) {
            return response()->json($validation->errors(), 422);
        }

        $subtask->fill($request->input())->update();
        return response()->json([
            'message' => 'Updated',
            'subtask' => $subtask,
            'validation' => $validation
        ]);
    }

    public function updateSubStatus(Request $request, Subtask $subtask)
    {
        $validation = Validator::make(
            $request->all(),
            [
                'status' => 'required'
            ],
            [
                'status.required' => 'Insira o status'
            ]
        );

        if ($validation->fails()) {
            return response()->json($validation->errors(), 422);
        }

        $subtask->update(['status' => $request->input('status')]);

        return response()->json([
            'message' => 'Substatus updated',
            'task' => $subtask
        ]);
    }


    public function destroy(Subtask $subtask)
    {
        $subtask->delete();
        return response()->json([
            'message' => 'Subtask deleted'
        ]);
    }
}
