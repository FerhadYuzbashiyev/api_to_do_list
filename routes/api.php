<?php

use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::apiResource('task', TaskController::class);
Route::put('task/{task}/complete', [TaskController::class, 'complete']);