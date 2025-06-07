<?php

namespace App\Http\Controllers;

use App\Support\Enums\LogLevel;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Throwable;

abstract class WebController
{
    /**
     * @throws Throwable
     */
    public function __invoke(): RedirectResponse|View
    {
        try {
            return $this->handle();
        }  catch (Throwable $e) {
            log_message(LogLevel::ERROR, $e->getMessage(), $e->getTrace());
            throw $e;
        }
    }

    abstract protected function handle(): RedirectResponse|View;
}
