<?php

namespace App\Http\Controllers\v1\Docs;

use App\Http\Controllers\Controller;
use App\Http\Controllers\WebController;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

final class DocsViewController extends WebController
{
    protected function handle(): RedirectResponse|View
    {
        $endpoints = json_decode(
            file_get_contents(resource_path('docs/api-endpoints.json')),
            true
        );

        return view('docs.api', compact('endpoints'));
    }
}
