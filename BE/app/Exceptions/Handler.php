<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use \Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\UnauthorizedException;
use Throwable, Exception;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->renderable(function (Exception $e, $request) {
            return $this->handleException($request, $e);
        });

        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * Convert an authentication exception into a response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Auth\AuthenticationException  $exception
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        return response()->json([
            'status' => Response::HTTP_UNAUTHORIZED,
            'message' => $exception->getMessage(),
        ], Response::HTTP_UNAUTHORIZED);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Exception $exception
     * @return Response
     */
    public function handleException($_, Exception $e): Response
    {
        switch ($e) {
            case $e instanceof ValidationException:
                return response()->json($e->getResponse()->original, Response::HTTP_UNPROCESSABLE_ENTITY);
            case $e instanceof NotFoundHttpException || $e instanceof RouteNotFoundException || $e instanceof ModelNotFoundException:
                return response()->json([
                    'status' => Response::HTTP_NOT_FOUND,
                    'message' => '404 Not Found',
                ], Response::HTTP_NOT_FOUND);
            case $e instanceof UnauthorizedException:
                return response()->json([
                    'status' => Response::HTTP_UNAUTHORIZED,
                    'message' => 'Unauthorized',
                ], Response::HTTP_UNAUTHORIZED);
            default:
                return response()->json([
                    'status' => JsonResponse::HTTP_INTERNAL_SERVER_ERROR,
                    'message' => __("messages." . JsonResponse::HTTP_INTERNAL_SERVER_ERROR),
                ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
