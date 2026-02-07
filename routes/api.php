<?php

use App\Http\Controllers\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::apiResource('task', TaskController::class);
Route::put('task/complete/{task}', [TaskController::class, 'complete']);