<?php

namespace App\Http\Controllers\Api\V1;

use App\Actions\Task\CreateNewTask;
use App\Actions\Task\FetchTask;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Resources\V1\TaskResource;
use App\Models\Task;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $tasks = app(FetchTask::class)->execute();
        return TaskResource::collection($tasks);
    }

    public function store(StoreTaskRequest $request): JsonResource
    {
        $task = app(CreateNewTask::class)->execute($request->validated());
        return TaskResource::make($task);
    }

    public function show(Task $task): JsonResource
    {
        return TaskResource::make($task);
    }

    public function update(StoreTaskRequest $request, Task $task)
    {
        $task->update($request->validated());
        return TaskResource::make($task->refresh());
    }

    public function destroy(Task $task)
    {
        $deleted = $task->delete();

        if ($deleted) {
            return response()->json([
                'success' => true,
                'message' => 'Task deleted successfully.'
            ]);
        }

        return response()->json([
            'message' => 'Task not deleted. Please try again.'
        ]);
    }
}
