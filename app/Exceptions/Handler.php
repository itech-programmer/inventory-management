<?php

namespace App\Exceptions;

use App\Contracts\ApiResponseServiceInterface;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;
use Symfony\Component\HttpKernel\Exception\TooManyRequestsHttpException;
use App\Services\ApiResponseService;

class Handler extends ExceptionHandler
{
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    public function register(): void
    {
        $this->reportable(function (Throwable $exception) {
            //
        });
    }

    public function render($request, Throwable $exception)
    {
        $apiResponse = app(ApiResponseServiceInterface::class);

        // Ошибка валидации (422)
        if ($exception instanceof ValidationException) {
            return $apiResponse->error('Validation failed', $exception->errors(), 422);
        }

        // Ресурс не найден (404)
        if ($exception instanceof ModelNotFoundException || $exception instanceof NotFoundHttpException) {
            return $apiResponse->error('Resource not found', [], 404);
        }

        // Ошибка аутентификации (401)
        if ($exception instanceof AuthenticationException || $exception instanceof UnauthorizedHttpException) {
            return $apiResponse->error('Unauthorized', [], 401);
        }

        // Ошибка доступа (403)
        if ($exception instanceof AuthorizationException || $exception instanceof AccessDeniedHttpException) {
            return $apiResponse->error('Forbidden', [], 403);
        }

        // Метод не поддерживается (405)
        if ($exception instanceof MethodNotAllowedHttpException) {
            return $apiResponse->error('Method Not Allowed', [], 405);
        }

        // Конфликт данных (409)
        if ($exception instanceof ConflictHttpException) {
            return $apiResponse->error('Conflict', [], 409);
        }

        // Слишком много запросов (429)
        if ($exception instanceof TooManyRequestsHttpException) {
            return $apiResponse->error('Too Many Requests', [], 429);
        }

        // Ошибка базы данных (500)
        if ($exception instanceof QueryException) {
            return $apiResponse->error(
                'Database error',
                [],
                500
            );
        }

        // Общее HTTP-исключение
        if ($exception instanceof HttpException) {
            return $apiResponse->error($exception->getMessage(), [], $exception->getStatusCode());
        }

        // Неизвестная ошибка (500) без trace в продакшене
        $message = config('app.debug') ? $exception->getMessage() : 'Something went wrong, please try again later';

        return $apiResponse->error($message, [], 500);
    }

}
