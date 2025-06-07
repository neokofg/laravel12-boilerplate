<?php

namespace App\Http\Requests\v1\Auth;

use App\Support\Rules\AuthRules;
use Illuminate\Foundation\Http\FormRequest;

class RegisterUserRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:' . AuthRules::passwordMin() . '|max:' . AuthRules::passwordMax(),
        ];
    }
}
