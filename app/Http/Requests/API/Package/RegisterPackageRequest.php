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
            'customer_id' => ['required', 'exists:customers,id'],
            'package_id' => ['required', 'exists:packages,id'],
        ];
    }
}
