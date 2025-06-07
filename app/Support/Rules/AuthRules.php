<?php

namespace App\Support\Rules;

final class AuthRules
{
    public static function passwordMin(): int
    {
        return config('app_rules.auth_rules.password_min_length');
    }

    public static function passwordMax(): int
    {
        return config('app_rules.auth_rules.password_max_length');
    }
}
