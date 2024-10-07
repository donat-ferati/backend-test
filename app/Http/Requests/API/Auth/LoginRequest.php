<?php

namespace App\Http\Requests\API\Auth;

use App\Http\Requests\APIRequest;

class LoginRequest extends APIRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => ['required', 'email'],
            'password' => ['required', 'string', 'min:8']
        ];
    }
}
