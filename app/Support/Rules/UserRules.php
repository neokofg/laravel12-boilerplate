<?php

namespace App\Support\Rules;

final class UserRules
{
    public static function userNameMin(): int
    {
        return config('app_rules.user_rules.user_name_min_length');
    }

    public static function userNameMax(): int
    {
        return config('app_rules.user_rules.user_name_max_length');
    }
}
