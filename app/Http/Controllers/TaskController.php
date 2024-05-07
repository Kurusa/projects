<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskIndexRequest;
use App\Http\Requests\TaskStoreRequest;
use App\Http\Requests\TaskUpdateRequest;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use App\Services\TaskService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class TaskController extends Controller
{
    public function __construct(readonly TaskService $service)
    {
    }

    public function index(TaskIndexRequest $request): AnonymousResourceCollection
    {
        $tasks = $this->service->search($request->user(), $request->validated());

        return TaskResource::collection($tasks);
    }

    public function store(TaskStoreRequest $request): TaskResource
    {
        $task = $this->service->store($request->user(), $request->validated());

        return TaskResource::make($task);
    }

    public function complete(Task $task): JsonResponse
    {
        try {
            $task = $this->service->complete($task);

            return TaskResource::make($task);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    public function update(Task $task, TaskUpdateRequest $request): JsonResponse
    {
        try {
            $task = $this->service->update($task, $request->validated());
            return TaskResource::make($task);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    public function show(Task $task): TaskResource
    {
        return TaskResource::make($task);
    }

    public function destroy(Task $task): JsonResponse
    {
        try {
            $this->service->delete($task);

            return response()->json([], Response::HTTP_NO_CONTENT);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
}
