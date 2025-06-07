<?php

namespace App\Http\Controllers\v1\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\v1\User\AuthenticatedUserResource;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class GetAuthenticatedUserController extends Controller
{
    /**
     * @throws AuthorizationException
     */
    protected function handle(): JsonResponse
    {
        return fast_response(data: AuthenticatedUserResource::make(getUser()));
    }
}
