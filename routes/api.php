<?php

use App\Http\Controllers\SubtaskController;
use App\Http\Controllers\TaskController;
use App\Models\Task;
// use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');


Route::prefix('task')->controller(TaskController::class)->group(function() {
    Route::post('', 'create');
    Route::get('', 'index');
    Route::get('/{task}', 'show');
    Route::put('/{task}', 'update');
    Route::patch('/{task}', 'updateStatus');
    Route::delete('/{task}', 'destroy');
});

