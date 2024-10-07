<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\APIController;
use App\Http\Requests\API\Auth\LoginRequest;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class LoginController extends APIController
{
    public function __invoke(LoginRequest $request)
    {
        $user = null;
        $customer = Customer::query()->where('email', $request->email)->first();

        if ($customer && Hash::check($request->password, $customer->password)) {
            $token = $customer->createToken('auth_token')->plainTextToken;
            $data = [
                'type' => 'customer',
                'user' => $customer,
                'token' => $token,
            ];
            return $this->respondWithSuccess($data, __('app.customer_welcome', ['name' => $customer->name]));
        }

        $user = User::query()->where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            $token = $user->createToken('auth_token')->plainTextToken;
            $data = [
                'type' => 'user',
                'user' => $user,
                'token' => $token,
            ];
            return $this->respondWithSuccess($data, __('app.user_welcome', ['name' => $user->name]));
        }

        return $this->respondWithError(null, __('auth.failed'), 401);
    }
}
