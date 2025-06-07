<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

class RateLimitServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        $this->configureRateLimiting();
    }

    private function configureRateLimiting(): void
    {
        $limiter = fn($name, $limit, $by, $method = 'perMinute') =>
            RateLimiter::for($name, fn(Request $r) => Limit::{$method}($limit)->by($by($r)));

        $limiter('api',
            app()->isProduction() ? 60 : 999,
            fn($r) => $r->user()?->id ?: $r->ip()
        );

        $limiter('auth',
            app()->isProduction() ? 5 : 999,
            fn($r) => $r->ip()
        );

        $limiter('auth:register',
            app()->isProduction() ? 3 : 999,
            fn($r) => $r->ip(),
            'perHour'
        );
    }
}
