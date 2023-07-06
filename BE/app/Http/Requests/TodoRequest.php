<?php

namespace App\Http\Requests;

use App\Abstracts\AbstractRequest;
use App\Enums\TodoStatusEnum;
use Illuminate\Validation\Rule;

/**
 * @OA\Schema(
 *      title="Store Todo request",
 *      description="Store Todo request body data",
 *      type="object",
 *      required={"title", "start_date", "due_date"}
 * )
 */
class TodoRequest extends AbstractRequest
{
    /**
     * @OA\Property(
     *      title="Title",
     *      description="title of the new todo",
     *      example="A nice todo"
     * )
     *
     * @var string
     */
    public $title;

    /**
     * @OA\Property(
     *      title="Description",
     *      description="Description of the new todo",
     *      example="This is new todo's description"
     * )
     *
     * @var string
     */
    public $description;

    /**
     * @OA\Property(
     *     title="Start date",
     *     description="Start date",
     *     example="2020-01-27",
     *     format="datetime",
     *     type="string"
     * )
     *
     * @var \Date
     */
    private $start_date;


    /**
     * @OA\Property(
     *     title="Due Date",
     *     description="Due Date",
     *     example="2020-01-27",
     *     format="datetime",
     *     type="string"
     * )
     *
     * @var \Date
     */
    private $due_date;
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
        $rules = [
            'title' => 'required|max:255',
            'description' => 'nullable|max:2000',
            'start_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:start_date',
            'user_id' => [
                'nullable',
                Rule::exists('users', 'id')->whereNull('deleted_at')
            ]
        ];

        if (strtolower($this->method()) == 'put') {
            $rules = [
                ...$rules,
                'status' => 'nullable|in:' . implode(',', TodoStatusEnum::getValues()),
            ];
        }

        return $rules;
    }
}
