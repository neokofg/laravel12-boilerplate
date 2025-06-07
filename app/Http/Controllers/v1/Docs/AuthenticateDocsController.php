<?php

namespace App\Http\Controllers\v1\Docs;

use App\Http\Controllers\WebController;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

final class AuthenticateDocsController extends WebController
{
    /**
     * @throws ValidationException
     */
    protected function handle(): RedirectResponse|View
    {
        $request = app(Request::class)->validate([
            'password' => 'required|string'
        ]);

        $correctPassword = config('docs.password', 'secret123');

        if (!Hash::check($request['password'], Hash::make($correctPassword)) &&
            $request['password'] !== $correctPassword) {
            throw ValidationException::withMessages([
                'password' => [__('Неверный пароль')],
            ]);
        }

        session(['docs_authenticated' => true]);

        return redirect()->route('docs.api')
            ->with('success', __('Успешно авторизован'));
    }
}
