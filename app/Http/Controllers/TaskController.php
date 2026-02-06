<?php

namespace App\Http\Controllers;

use App\DTO\CreateTaskData;
use App\DTO\UpdateTaskData;
use App\Models\Task;
use App\Service\TaskService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TaskController extends Controller
{
    public function __construct(
        private TaskService $taskService
    ) {}

    public function index()
    {
        return response()->json(Task::all(), Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        try {
                $request->validate([
                    'title' => 'required|string|max:255',
                    'description' => 'required|string'
                ]);
            } catch (\Illuminate\Validation\ValidationException $e) {
                return response()->json([
                    'message' => 'Validation failed',
                    'errors' => $e->errors(),
                ], Response::HTTP_UNPROCESSABLE_ENTITY);
            }
        $dto = CreateTaskData::fromRequest($request);
        $task = $this->taskService->createTask($dto);
        
        return response()->json([
            'message' => 'Task created successfully!',
            'Task' => $task
        ], Response::HTTP_CREATED);
    }

    public function show(Task $task)
    {
        return response()->json($task, Response::HTTP_OK);
    }

    public function update(Request $request, Task $task)
    {
        try {
                $request->validate([
                    'title' => 'sometimes|string|max:255',
                    'description' => 'sometimes|string'
                ]);
            } catch (\Illuminate\Validation\ValidationException $e) {
                return response()->json([
                    'message' => 'Validation failed',
                    'errors' => $e->errors(),
                ], Response::HTTP_UNPROCESSABLE_ENTITY);
            }
        $dto = UpdateTaskData::fromRequest($request);
        $updatedTask = $this->taskService->updateTask($task, $dto);

        return response()->json([
            'message' => 'Task updated successfully!',
            'task' => $updatedTask
        ], Response::HTTP_OK);

    }

    public function complete(Task $task)
    {
        $task = $this->taskService->completeTask($task);
        return response()->json([
            'message' => 'Task completed successfully!',
            'completed task' => $task 
        ], Response::HTTP_OK);
    }

    public function destroy(Task $task)
    {
        Task::destroy($task->id);
        return response()->json(Response::HTTP_NO_CONTENT);
    }
}
