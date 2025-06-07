<?php

namespace App\Http\Controllers\v1\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class LogoutUserController extends Controller
{
    /**
     * @throws AuthorizationException
     */
    protected function handle(): JsonResponse
    {
        $user = getUser();

        $user->currentAccessToken()->delete();

        return fast_response();
    }
}
