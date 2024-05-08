<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     title="Task Resource",
 *     description="Task resource",
 *     @OA\Xml(
 *         name="TaskResource"
 *     )
 * )
 */
class TaskResource extends JsonResource
{
    /**
     * @OA\Property(
     *     property="id",
     *     type="integer"
     * ),
     * @OA\Property(
     *     property="title",
     *     type="string"
     * ),
     * @OA\Property(
     *     property="description",
     *     type="string"
     * ),
     * @OA\Property(
     *     property="status",
     *     type="string",
     *     enum={"todo", "in_progress", "complete"}
     * ),
     * @OA\Property(
     *     property="priority",
     *     type="integer"
     * ),
     * @OA\Property(
     *     property="created_at",
     *     type="string",
     *     format="date-time"
     * ),
     * @OA\Property(
     *     property="updated_at",
     *     type="string",
     *     format="date-time"
     * ),
     * @OA\Property(
     *     property="completed_at",
     *     type="string",
     *     format="date-time"
     * )
     *
     * @param Request $request
     * @return array
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'status' => $this->status,
            'priority' => $this->priority,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'completed_at' => $this->completed_at,
        ];
    }
}
