<?php

namespace App\Http\Controllers\Api;

use App\Abstracts\AbstractController;
use App\Http\Requests\AssignTodoRequest;
use App\Http\Requests\{ChangeStatusTodoRequest, TodoRequest, TodoSearchRequest};
use App\Http\Resources\TodoResource;
use App\Models\Todo;
use App\Services\TodoService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

/**
 * @OA\Tag(
 *     name="Todos",
 *     description="API Endpoints of Todos"
 * )
 */
class TodoController extends AbstractController
{
    public function __construct(private readonly TodoService $todoService)
    {
    }

    /**
     * @OA\Get(
     *     path="/todos",
     *     summary="Retrieve todos",
     *     tags={"Todos"},
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         description="The page number for pagination",
     *         @OA\Schema(
     *             type="integer",
     *         )
     *     ),
    *      @OA\Parameter(
     *         name="title",
     *         in="query",
     *         description="The title search todo",
     *         @OA\Schema(
     *             type="integer",
     *         )
     *     ),
    *      @OA\Parameter(
     *         name="start_date",
     *         in="query",
     *         description="The start_date search for todo",
     *         @OA\Schema(
     *             type="date",
     *         )
     *     ),
    *      @OA\Parameter(
     *         name="due_date",
     *         in="query",
     *         description="The due_date search for todo",
     *         @OA\Schema(
     *             type="date",
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="OK",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/Todo")
     *             ),
     *         )
     *     )
     * )
     */

    public function index(TodoSearchRequest $query)
    {
        $data = $this->todoService->paginate($query->all());
        return TodoResource::collection($data);
    }

    /**
     * @OA\Post(
     *      path="/todos",
     *      operationId="storeTodo",
     *      tags={"Todos"},
     *      summary="Store new Todo",
     *      description="Returns Todo data",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/TodoRequest")
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Todo")
     *       ),
     *       @OA\Response(
     *          response=422,
     *          description="Validation failed",
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     */
    public function store(TodoRequest $request)
    {
        $inputs = $request->validated();
        $todo = $this->todoService->store($inputs);

        return $this->jsonResponse(JsonResponse::HTTP_CREATED, data: new TodoResource($todo));
    }

    /**
     * @OA\Get(
     *      path="/todos/{id}",
     *      operationId="gettodoById",
     *      tags={"Todos"},
     *      summary="Get todo information",
     *      description="Returns todo data",
     *      @OA\Parameter(
     *          name="id",
     *          description="todo id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Todo")
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Not found"
     *      )
     * )
     */
    public function show(string $id)
    {
        $todo = $this->todoService->show($id);

        return $this->jsonResponse(JsonResponse::HTTP_OK, data: new TodoResource($todo));
    }

    /**
     * @OA\Put(
     *      path="/todos/{id}",
     *      operationId="updateTodo",
     *      tags={"Todos"},
     *      summary="Update Todo",
     *      description="Returns Todo data",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/TodoRequest")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                  @OA\Items()
     *             ),
     *              @OA\Property(
     *                 property="message",
     *                 type="string"
     *             ),
     *         )
     *       ),
     *       @OA\Response(
     *          response=422,
     *          description="Validation failed",
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     */
    public function update(TodoRequest $request, int $id)
    {
        $inputs = $request->validated();
        $this->todoService->update($id, $inputs);

        return $this->jsonResponse(JsonResponse::HTTP_OK, message: __('messages.update_successfully'));
    }

    /**
     * @OA\Delete(
     *      path="/todos/{id}",
     *      operationId="deleteTodo",
     *      tags={"Todos"},
     *      summary="Delete existing todo",
     *      description="Deletes a record and returns no content",
     *      @OA\Parameter(
     *          name="id",
     *          description="todo id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=204,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                  @OA\Items()
     *             ),
     *              @OA\Property(
     *                 property="message",
     *                 type="string"
     *             ),
     *         )
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Not Found"
     *      )
     * )
     */
    public function destroy(Todo $todo)
    {
        $todo->delete();

        return $this->jsonResponse(JsonResponse::HTTP_OK, message: __('messages.update_successfully'));
    }

    /**
     * @OA\Post(
     *      path="/assign-user",
     *      operationId="assignUser",
     *      tags={"Todos"},
     *      summary="assign user to Todo",
     *      description="assign user to Todo",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/AssignTodoRequest")
     *      ),
     *      @OA\Response(
     *          response=204,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                  @OA\Items()
     *             ),
     *              @OA\Property(
     *                 property="message",
     *                 type="string"
     *             ),
     *         )
     *       ),
     *       @OA\Response(
     *          response=422,
     *          description="Validation failed",
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     */
    public function assignTodoToUser(AssignTodoRequest $request)
    {
        $inputs = $request->validated();
        $this->todoService->assignTodo($inputs);

        return $this->jsonResponse(JsonResponse::HTTP_OK, message: __('messages.assign_successfully'));
    }

    /**
     * @OA\Post(
     *      path="/change-status",
     *      operationId="changeStatus",
     *      tags={"Todos"},
     *      summary="Change status to Todo",
     *      description="Change status to Todo",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/ChangeStatusTodoRequest")
     *      ),
     *      @OA\Response(
     *          response=204,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                  @OA\Items()
     *             ),
     *              @OA\Property(
     *                 property="message",
     *                 type="string"
     *             ),
     *         )
     *       ),
     *       @OA\Response(
     *          response=422,
     *          description="Validation failed",
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     */
    public function changeStatusTodo(ChangeStatusTodoRequest $request)
    {
        $inputs = $request->validated();
        $this->todoService->changeStatus($inputs);

        return $this->jsonResponse(JsonResponse::HTTP_OK, message: __('messages.change_status_successfully'));
    }
}
