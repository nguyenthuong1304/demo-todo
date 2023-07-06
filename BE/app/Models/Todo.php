<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @OA\Schema(
 *     title="Todo",
 *     description="Todo model",
 *     @OA\Xml(
 *         name="Todo"
 *     )
 * )
 */
class Todo extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * @OA\Property(
     *     title="ID",
     *     description="ID",
     *     format="int64",
     *     example=1
     * )
     *
     * @var integer
     */
    private $id;

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
     *     title="Created at",
     *     description="Created at",
     *     example="2020-01-27 17:50:45",
     *     format="datetime",
     *     type="string"
     * )
     *
     * @var \DateTime
     */
    private $created_at;

    /**
     * @OA\Property(
     *     title="Updated at",
     *     description="Updated at",
     *     example="2020-01-27 17:50:45",
     *     format="datetime",
     *     type="string"
     * )
     *
     * @var \DateTime
     */
    private $updated_at;

    /**
     * @OA\Property(
     *     title="Deleted at",
     *     description="Deleted at",
     *     example="2020-01-27 17:50:45",
     *     format="datetime",
     *     type="string"
     * )
     *
     * @var \DateTime
     */
    private $deleted_at;

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
    private $user_id;

    /**
     * @OA\Property(
     *     title="Assignee",
     *     description="Todo author's user model"
     * )
     *
     * @var \App\Models\User
     */
    private $user;

    protected $fillable = [
        'id',
        'title',
        'description',
        'status',
        'start_date',
        'due_date',
        'user_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
