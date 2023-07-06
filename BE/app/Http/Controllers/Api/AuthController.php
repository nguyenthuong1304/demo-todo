<?php

namespace App\Http\Controllers\Api;

use App\Abstracts\AbstractController;
use Illuminate\Validation\UnauthorizedException;

/**
 * @OA\Tag(
 *     name="Auth",
 *     description="API Endpoints of Auth"
 * )
 */
class AuthController extends AbstractController
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    /**
     * @OA\Post(
     *     path="/login",
     *     summary="User login",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="email", type="string"),
     *             @OA\Property(property="password", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="OK",
     *         @OA\JsonContent(
     *             @OA\Property(property="access_token", type="string"),
     *             @OA\Property(property="expires_in", type="string", example="bearer"),
     *             @OA\Property(property="token", type="datetime"),
     *         )
     *     ),
     *     @OA\Response(
     *         response="401",
     *         description="Unauthorized"
     *     )
     * )
     */
    public function login()
    {
        $credentials = request(['email', 'password']);

        if (!$token = auth()->attempt($credentials)) {
            throw new UnauthorizedException();
        }

        return $this->respondWithToken($token);
    }

    /**
     * @OA\Get(
     *     path="/me",
     *     summary="Get the authenticated User",
     *     tags={"Auth"},
     *     @OA\Response(
     *         response="200",
     *         description="OK",
     *         @OA\JsonContent(
     *              @OA\Property(property="data", ref="#/components/schemas/User"),
     *              @OA\Property(property="message", type="string"),
     *         )
     *     ),
     *     @OA\Response(
     *         response="401",
     *         description="Unauthorized"
     *     )
     * )
     */
    public function me()
    {
        return $this->jsonResponse(data: auth()->user());
    }

    /**
     * @OA\Post(
     *     path="/logout",
     *     summary="Log the user out (Invalidate the token)",
     *     tags={"Auth"},
     *     @OA\Response(
     *         response="200",
     *         description="OK",
     *         @OA\JsonContent(
     *              @OA\Property(
     *                 property="data",
     *                 type="array",
     *                  @OA\Items()
     *             ),
     *              @OA\Property(property="message", type="string"),
     *         )
     *     )
     * )
     */
    public function logout()
    {
        auth()->logout();

        return $this->jsonResponse(message: 'Successfully logged out');
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ];
    }
}
