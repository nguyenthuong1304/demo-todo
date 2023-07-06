<?php

namespace App\Http\Requests;

use App\Abstracts\AbstractRequest;
use App\Enums\TodoStatusEnum;

/**
 * @OA\Schema(
 *      title="Search Todo request",
 *      description="Search todo query data",
 *      type="object",
 * )
 */
class TodoSearchRequest extends AbstractRequest
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

    public function rules(): array
    {
        return [
            'title' => 'nullable',
            'start_date' => 'nullable|date',
            'due_date' => 'nullable|date|after_or_equal:start_date',
            'status' => 'nullable|in:' . implode(',', TodoStatusEnum::getValues()),
        ];
    }
}
