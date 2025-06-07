<?php

use App\Support\Enums\LogLevel;
use Illuminate\Support\Facades\Log;

function log_message(LogLevel $level, string $message, array $trace = []): void
{
    Log::{$level->value}($message, $trace);
}
