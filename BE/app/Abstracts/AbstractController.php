<?php

namespace App\Abstracts;

use App\Http\Controllers\Controller;

/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="Laravel OpenApi Demo Documentation",
 *      description="L5 Swagger OpenApi description",
 *      @OA\Contact(
 *          email="admin@admin.com"
 *      ),
 *      @OA\License(
 *          name="Apache 2.0",
 *          url="http://www.apache.org/licenses/LICENSE-2.0.html"
 *      )
 * )
 *
 * @OA\Server(
 *      url=L5_SWAGGER_CONST_HOST,
 *      description="Demo API Server"
 * )
 */
abstract class AbstractController extends Controller
{

    /**
     * @param $status
     * @param $data[]
     * @param $message
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function jsonResponse($status = 200, $data = [], $message = null)
    {
        $compacts['status'] = $status;
        $compacts['message'] = $message ?? __('messages.response_successfully');
        $compacts['data'] = $data;

        return response()->json($compacts, $status);
    }
}
