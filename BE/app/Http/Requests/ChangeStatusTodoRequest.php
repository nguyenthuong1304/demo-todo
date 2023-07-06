<?php

namespace App\Http\Requests;

use App\Abstracts\AbstractRequest;
use App\Enums\TodoStatusEnum;
use Illuminate\Validation\Rule;

/**
 * @OA\Schema(
 *      title="Change status to Todo request",
 *      description="Change status to Todo reques body data",
 *      type="object",
 *      required={"todo_ids", "status"}
 * )
 */
class ChangeStatusTodoRequest extends AbstractRequest
{
    /**
     * @OA\Property(
     *     title="Due Date",
     *     description="Due Date",
     *     example="[1,2]",
     *     type="array",
     *      @OA\Items(
     *          type="array",
     *          @OA\Items()
     *      ),
     * )
     *
     * @var \Array
     */
    private $todo_ids;

    /**
     * @OA\Property(
     *      title="Todo status",
     *      description="Todo status",
     *      format="int64",
     *      example=1
     * )
     *
     * @var integer
     */
    public $status;

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'todo_ids' => 'required|array',
            'todo_ids.*' => [
                'integer',
                Rule::exists('todos', 'id')->whereNull('deleted_at'),
            ],
            'status' => 'required|in:' . implode(',', TodoStatusEnum::getValues()),
        ];
    }
}
