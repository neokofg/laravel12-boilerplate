<?php

namespace App\Http\Controllers\v1\Docs;

use App\Http\Controllers\WebController;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

final class LoginDocsViewController extends WebController
{
    protected function handle(): RedirectResponse|View
    {
        if (session('docs_authenticated')) {
            return redirect()->route('docs.api');
        }

        return view('docs.login');
    }
}
