<?php

namespace App\Http\Controllers\v1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\Auth\RegisterUserRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

final class RegisterUserController extends Controller
{
    protected function handle(): JsonResponse
    {
        $request = app(RegisterUserRequest::class)->validated();

        $result = DB::transaction(function () use ($request) {
            $user = User::create($request);
            $valid_until = getFullDate(now()->addMonth());

            return [
                'token' => createToken($user, expiresAt: $valid_until),
                'valid_until' => $valid_until,
            ];
        });

        return fast_response(data: $result, code: Response::HTTP_CREATED);
    }
}
