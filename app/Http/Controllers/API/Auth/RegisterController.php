<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\APIController;
use App\Http\Requests\API\Auth\RegisterRequest;
use App\Models\Customer;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class RegisterController extends APIController
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(RegisterRequest $request)
    {
        $customer = Customer::query()
            ->create([
            'uuid' => Str::uuid(),
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return $this->respondWithSuccess($customer, __('app.created_successfully', ['instance' => __('app.customer')]));
    }
}
