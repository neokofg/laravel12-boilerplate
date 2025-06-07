<?php

namespace App\Http\Controllers\v1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\Auth\LoginUserRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

final class LoginUserController extends Controller
{
    protected function handle(): JsonResponse
    {
        $request = app(LoginUserRequest::class)->validated();

        $result = DB::transaction(function () use ($request) {
            authenticate($request);

            $valid_until = getFullDate(now()->addMonth());

            return [
                'token' => createToken(getUser('web'), expiresAt: $valid_until),
                'valid_until' => $valid_until,
            ];
        });

        return fast_response(data: $result);
    }
}
