<?php

namespace App\Http\Requests;

use App\Abstracts\AbstractRequest;
use Illuminate\Validation\Rule;

/**
 * @OA\Schema(
 *      title="Assign user to Todo request",
 *      description="Assign user to Todo reques body data",
 *      type="object",
 *      required={"user_id", "todo_ids"}
 * )
 */
class AssignTodoRequest extends AbstractRequest
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
     *      title="Assignee ID",
     *      description="Assignee's id of the new todo",
     *      format="int64",
     *      example=1
     * )
     *
     * @var integer
     */
    public $user_id;

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'user_id' => [
                'required',
                Rule::exists('users', 'id')->whereNull('deleted_at')
            ],
            'todo_ids' => 'required|array',
            'todo_ids.*' => [
                'integer',
                Rule::exists('todos', 'id')->whereNull('deleted_at'),
            ]
        ];
    }
}
