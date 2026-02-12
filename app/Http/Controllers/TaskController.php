<?php

namespace App\Http\Controllers;

use App\DTO\CreateTaskData;
use App\DTO\UpdateTaskData;
use App\Http\Requests\Task\CreateTaskRequest;
use App\Http\Requests\Task\UpdateTaskRequest;
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
        return response()->json([
            'data' => Task::all()], Response::HTTP_OK);
    }

    public function store(CreateTaskRequest $request)
    {
        $dto = CreateTaskData::fromArray($request);
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

    public function update(UpdateTaskRequest $request, Task $task)
    {
        $dto = UpdateTaskData::fromArray($request);
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
