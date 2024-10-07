<?php

namespace App\Http\Controllers\API\Package;

use App\Http\Controllers\APIController;
use App\Models\Customer;
use App\Models\Package;
use Illuminate\Support\Facades\Cache;

class ListPackagesController extends APIController
{
    public function __invoke()
    {
        $authenticatedUser = auth()->user();
        if (!($authenticatedUser instanceof Customer)) {
            return $this->respondWithError(null, __('app.user_not_customer'), 403);
        }

        $customerId = $authenticatedUser->getKey();

        $cacheKey = "customer_{$customerId}_packages";

        $data = Cache::remember($cacheKey, now()->addWeeks(), function () use ($customerId) {
            return Package::query()
                ->whereHas('registrations', function ($query) use ($customerId) {
                    $query->where('customer_id', $customerId);
                })
                ->withCount('registrations')
                ->get()
                ->map(function ($package) {
                    $package->availability = $package->registrations_count < $package->limit ? __('app.available') : __('app.unavailable');
                    return $package;
                });
        });

        return $this->respondWithSuccess($data);
    }
}
