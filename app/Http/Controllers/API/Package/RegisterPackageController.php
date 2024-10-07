<?php

namespace App\Http\Controllers\API\Package;

use App\Http\Controllers\APIController;
use App\Http\Requests\API\Package\RegisterPackageRequest;
use App\Models\Package;
use App\Models\Registration;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class RegisterPackageController extends APIController
{
    public function __invoke(RegisterPackageRequest $request)
    {
        $package = Package::query()
            ->withCount('registrations')
            ->find($request->package_id);

        if ($package->registrations_count >= $package->limit) {
            return $this->respondWithError(null, __('app.package_not_available_registration'), 422);
        }

        $registration = Registration::query()
            ->create([
                'uuid' => Str::uuid(),
                'customer_id' => auth()->id(),
                'package_id' => $request->package_id,
                'registered_at' => now(),
            ]);

        $customerId = auth()->id();
        $cacheKey = "customer_{$customerId}_packages";

        Cache::forget($cacheKey);

        return $this->respondWithSuccess($registration);
    }
}
