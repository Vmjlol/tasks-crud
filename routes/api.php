<?php

use App\Http\Controllers\SubtaskController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthenticationController;

Route::middleware(['auth'])->group(function () {
    Route::prefix('task')->controller(TaskController::class)->group(function() {
        Route::post('', 'create');
        Route::get('', 'index');
        Route::get('/today', 'today');
        Route::get('/late', 'late');
        Route::get('/{task}', 'show');
        Route::put('/{task}', 'update');
        Route::patch('/{task}', 'updateStatus');
        Route::delete('/{task}', 'destroy');
    });

    Route::prefix('subtask')->controller(SubtaskController::class)->group(function() {
        Route::post('', 'create');
        Route::get('', 'index');
        Route::get('/{subtask}', 'show');
        Route::put('/{subtask}', 'update');
        Route::patch('/{subtask}', 'updateSubStatus');
        Route::delete('/{subtask}', 'destroy');
    });
});

Route::get('/register', function () {
    return "Ok";
});


Route::post('/register', [AuthenticationController::class, 'register']);
Route::post('/login', [AuthenticationController::class, 'login']);

