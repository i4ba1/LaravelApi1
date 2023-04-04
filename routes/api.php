<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TasksController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::group(['middleware' => ['auth:sanctum']], function (){
    Route::get('/task/tasks', [TasksController::class, 'index']);
    Route::post('/task/createTask', [TasksController::class, 'create']);
    Route::get('/task/getTaskById/{id}', [TasksController::class, 'show']);
    Route::put('/task/updateTask/{id}', [TasksController::class, 'update']);
    Route::delete('/task/deleteTask/{id}', [TasksController::class, 'destroy']);
    Route::post('/logout', [AuthController::class, 'logout']);
});
