<?php

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\HttpFoundation\Response;

function fast_response(?string $message = null, array|JsonResource|string $data = [], int $code = Response::HTTP_OK): JsonResponse
{
    return response()->json([
        'message' => $message ?? __('Successful'),
        'data' => $data,
    ], $code);
}

function fast_error_message(?string $message = null): string
{
    return __($message ?? 'Error');
}
