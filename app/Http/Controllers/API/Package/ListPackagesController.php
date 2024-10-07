<?php

namespace App\Http\Controllers\API\Package;

use App\Http\Controllers\APIController;
use App\Models\Package;

class ListPackagesController extends APIController
{
    public function __invoke()
    {
        $data = Package::query()
            ->withCount('registrations')
            ->get()
            ->map(function ($package) {
                $package->availability = $package->registrations_count < $package->limit ? __('app.available') : __('app.unavailable');
                return $package;
            });

        return $this->respondWithSuccess($data);
    }
}
