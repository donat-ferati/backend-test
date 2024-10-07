<?php

namespace App\Http\Requests\API\Package;

use App\Http\Requests\APIRequest;

class RegisterPackageRequest extends APIRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'package_id' => ['required', 'exists:packages,id']
        ];
    }
}
