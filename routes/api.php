<?php

use App\Http\Controllers\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::apiResource('task', TaskController::class)->only('index', 'store', 'show', 'destroy');
Route::post('task/update/{task}', [TaskController::class, 'update']);
Route::post('task/complete/{task}', [TaskController::class, 'complete']);