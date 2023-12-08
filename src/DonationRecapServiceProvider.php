<?php

declare(strict_types=1);

namespace Inisiatif\DonationRecap;

use Spatie\LaravelPackageTools\Package;
use Inisiatif\DonationRecap\Resolvers\DonorResolver;
use Spatie\LaravelPackageTools\PackageServiceProvider;

final class DonationRecapServiceProvider extends PackageServiceProvider
{
    public function registeringPackage(): void
    {
        $this->app->singleton(Resolvers\Contract\DonorResolver::class, DonorResolver::class);
    }

    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('donation-donor-recap')
            ->hasConfigFile('recap')
            ->hasMigration('create_donation_donor_recap_table')
            ->hasViews('recap');
    }
}
