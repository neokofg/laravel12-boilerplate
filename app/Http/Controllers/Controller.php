<?php

namespace App\Http\Controllers;

use App\Support\Enums\LogLevel;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

abstract class Controller
{
    public function __invoke(): JsonResponse
    {
        try {
            return $this->handle();
        } catch (ValidationException $e) {
            log_message(LogLevel::WARNING, $e->getMessage(), $e->getTrace());

            return fast_response(
                message: fast_error_message(__('Invalid data')),
                data: (array)$e->validator->errors()->messages(),
                code: Response::HTTP_UNPROCESSABLE_ENTITY
            );
        } catch (Throwable $e) {
            log_message(LogLevel::ERROR, $e->getMessage(), $e->getTrace());

            return fast_response(
                message: config('app.debug') ? $e->getMessage() : fast_error_message(),
                data: config('app.debug') ? (array)$e->getFile() : [],
                code: getCode($e->getCode()),
            );
        }
    }

    abstract protected function handle(): JsonResponse;
}
