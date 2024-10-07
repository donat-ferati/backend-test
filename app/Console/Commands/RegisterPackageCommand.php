<?php

namespace App\Console\Commands;

use App\Models\Customer;
use App\Models\Package;
use App\Models\Registration;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class RegisterPackageCommand extends Command
{
    protected $signature = 'register:package';
    protected $description = 'Register an additional package for an existing customer without app interaction';

    public function handle(): void
    {
        $customers = Customer::all();
        $packages = Package::withCount('registrations')->get();

        if ($customers->isEmpty()) {
            $this->error("No customers found in the system.");
            return;
        }

        if ($packages->isEmpty()) {
            $this->error("No packages found in the system.");
            return;
        }

        $customerName = $this->choice(
            'Select a customer',
            $customers->pluck('name', 'id')->toArray()
        );

        $customer = $customers->firstWhere('name', $customerName);
        if (!$customer) {
            $this->error("Invalid customer selection.");
            return;
        }

        $packageOptions = $packages->mapWithKeys(function ($package) {
            $availability = $package->registrations_count < $package->limit ? 'available' : 'unavailable';
            return [$package->id => "{$package->name} (ID: {$package->id}, $availability)"];
        });

        $selectedPackage = $this->choice('Select a package', $packageOptions->toArray());

        preg_match('/ID: (\d+)/', $selectedPackage, $matches);
        $packageId = $matches[1] ?? null;

        $package = $packages->firstWhere('id', $packageId);

        if (!$package || $package->registrations_count >= $package->limit) {
            $this->error("Package is not available for registration.");
            return;
        }

        Registration::query()->create([
            'uuid' => Str::uuid(),
            'customer_id' => $customer->id,
            'package_id' => $package->id,
            'registered_at' => now(),
        ]);


        $cacheKey = "customer_{$customer->id}_packages";
        Cache::forget($cacheKey);

        $this->info("Package '{$package->name}' successfully registered for customer '{$customer->name}'.");
    }
}
