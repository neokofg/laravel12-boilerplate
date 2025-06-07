<?php

namespace App\Http\Controllers\v1\Docs;

use App\Http\Controllers\WebController;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

final class LogoutDocsController extends WebController
{
    protected function handle(): RedirectResponse|View
    {
        session()->forget('docs_authenticated');

        return redirect()->route('docs.login')
            ->with('success', __('Успешный выход'));
    }
}
