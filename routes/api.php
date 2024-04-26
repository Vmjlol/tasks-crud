<?php

use App\Http\Controllers\SubtaskController;
use App\Http\Controllers\TaskController;
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
    Route::delete('/{task}', 'destroy');
});

Route::prefix('subtask')->controller(SubtaskController::class)->group(function() {
    Route::post('', 'create');
    Route::get('', 'index');
    Route::get('/{subtask}', 'show');
    Route::put('/{subtask}', 'update');
    Route::delete('/{subtask}', 'destroy');
});