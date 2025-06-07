<?php

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Auth;

function createToken(User $user, array $privileges = [],  DateTimeInterface|string|null $expiresAt = null): string
{
    return $user->createToken($user->id . ':token', [
        'role:user',
        ...$privileges
    ], Carbon::parse($expiresAt) ?? now()->addMonth())->plainTextToken;
}

/**
 * @throws AuthenticationException
 */
function authenticate(array $credentials): void
{
    if (!Auth::attempt($credentials)) {
        throw new AuthenticationException(__('Invalid email or password'));
    }
}

/**
 * @throws AuthorizationException
 */
function getUser(string $guard = 'sanctum'): User
{
    return getCurrentUser($guard) ?? throw new AuthorizationException(__('Unauthorized'));
}

function getCurrentUser(string $guard = 'sanctum'): User|Authenticatable|null
{
    return Auth::guard($guard)->user();
}
