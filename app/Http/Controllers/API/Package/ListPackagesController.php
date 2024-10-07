<?php

namespace App\Http\Controllers\API\Package;

use App\Http\Controllers\APIController;
use App\Models\Customer;
use App\Models\Package;

class ListPackagesController extends APIController
{
    public function __invoke()
    {
        $authenticatedUser = auth()->user();

        if ($authenticatedUser instanceof Customer) {
            $customerId = $authenticatedUser->getKey();

            $data = Package::query()
                ->whereHas('registrations', function ($query) use ($customerId) {
                    $query->where('customer_id', $customerId);
                })
                ->withCount('registrations')
                ->get()
                ->map(function ($package) {
                    $package->availability = $package->registrations_count < $package->limit ? __('app.available') : __('app.unavailable');
                    return $package;
                });

            return $this->respondWithSuccess($data);
        }

        return $this->respondWithError(null, __('app.user_not_customer'), 403);
    }
}
