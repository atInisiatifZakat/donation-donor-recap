<?php

declare(strict_types=1);

namespace Inisiatif\DonationRecap\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use Inisiatif\DonationRecap\DonationRecapServiceProvider;

abstract class TestCase extends Orchestra
{
    protected function getPackageProviders($app): array
    {
        return [
            DonationRecapServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app): void
    {
        config()->set('database.default', 'testing');
    }
}
