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

    public function index(Request $request)
    {
        return response()->json(subtask::paginate($request->input('per_page') ?? 10));
    }

    public function create(Request $request)
    {
        return Subtask::create($request->input());

        $validation = Validator::make(
            $request->all(),
            [
                'description' => 'required',
                'id_task' => 'required'
            ],
            [
                'description.required' => 'Insira uma descrição',
            ]
        );

        if ($validation->fails()) {
            return response()->json($validation->errors(), 422);
        }

        return response()->json([
            'message' => 'Success'
        ]);
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

        $subtask->fill($request->input())->update();
        return response()->json([
            'message' => 'Updated',
            'subtask' => $subtask
        ]);
    }


    public function destroy(Subtask $subtask)
    {
        $subtask->delete();
        return response()->json([
            'message' => 'Deleted!'
        ]);
    }
}
