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

/**
 * @OA\Tag(
 *     name="Tasks",
 *     description="Operations about tasks"
 * )
 */
class TaskController extends Controller
{
    public function __construct(readonly TaskService $service)
    {
    }

    /**
     * @OA\Get(
     *     path="/api/tasks",
     *     tags={"Tasks"},
     *     summary="List all tasks based on filters",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="status",
     *         in="query",
     *         required=false,
     *         description="Filter by task status",
     *         @OA\Schema(type="string", enum={"todo", "in_progress", "complete"})
     *     ),
     *     @OA\Parameter(
     *         name="priority",
     *         in="query",
     *         required=false,
     *         description="Filter by task priority",
     *         @OA\Schema(type="integer", format="int32")
     *     ),
     *     @OA\Parameter(
     *         name="text",
     *         in="query",
     *         required=false,
     *         description="Search text",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="sortBy",
     *         in="query",
     *         required=false,
     *         description="Sort by field",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="sortDirection",
     *         in="query",
     *         required=false,
     *         description="Sort direction (asc or desc)",
     *         @OA\Schema(type="string", enum={"asc", "desc"})
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/TaskResource"))
     *     )
     * )
     */
    public function index(TaskIndexRequest $request): AnonymousResourceCollection
    {
        $tasks = $this->service->search($request->user(), $request->validated());

        return TaskResource::collection($tasks);
    }

    /**
     * @OA\Post(
     *     path="/api/tasks",
     *     tags={"Tasks"},
     *     summary="Create a new task",
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         description="Data needed to create a new task",
     *         @OA\JsonContent(ref="#/components/schemas/TaskStoreRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Task created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/TaskResource")
     *     )
     * )
     */
    public function store(TaskStoreRequest $request): TaskResource
    {
        $task = $this->service->store($request->user(), $request->validated());

        return TaskResource::make($task);
    }

    /**
     * @OA\Put(
     *     path="/api/tasks/{taskId}/complete",
     *     tags={"Tasks"},
     *     summary="Complete a task",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="taskId",
     *         in="path",
     *         required=true,
     *         description="ID of the task to complete",
     *         @OA\Schema(type="integer", format="int64")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Task completed successfully",
     *         @OA\JsonContent(ref="#/components/schemas/TaskResource")
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Unprocessable Entity"
     *     )
     * )
     */
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

    /**
     * @OA\Patch(
     *     path="/api/tasks/{taskId}",
     *     tags={"Tasks"},
     *     summary="Update a task",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="taskId",
     *         in="path",
     *         required=true,
     *         description="ID of the task to update",
     *         @OA\Schema(type="integer", format="int64")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="Data needed to update the task",
     *         @OA\JsonContent(ref="#/components/schemas/TaskUpdateRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Task updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/TaskResource")
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Unprocessable Entity"
     *     )
     * )
     */
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

    /**
     * @OA\Get(
     *     path="/api/tasks/{taskId}",
     *     tags={"Tasks"},
     *     summary="Get a task",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="taskId",
     *         in="path",
     *         required=true,
     *         description="ID of the task",
     *         @OA\Schema(type="integer", format="int64")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/TaskResource")
     *     )
     * )
     */
    public function show(Task $task): TaskResource
    {
        return TaskResource::make($task);
    }

    /**
     * @OA\Delete(
     *     path="/api/tasks/{taskId}",
     *     tags={"Tasks"},
     *     summary="Delete a task",
     *     description="Deletes a task by ID and returns no content on successful operation.",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="taskId",
     *         description="Task ID",
     *         required=true,
     *         in="path",
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="No content (Task successfully deleted)"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Unprocessable Entity - Error occurred during the deletion process",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Cannot delete task because...")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized - API token missing or invalid"
     *     )
     * )
     */
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
