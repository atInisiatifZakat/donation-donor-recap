<?php

declare(strict_types=1);

namespace Inisiatif\DonationRecap\Tests;

use function Orchestra\Testbench\artisan;

use Illuminate\Support\Facades\DB;
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
        config()->set('database.connections.testing', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);

        config()->set('database.default', 'testing');
        config()->set('recap.recording.donor_table_name', 'donors');
        config()->set('recap.recording.employee_table_name', 'employees');
    }

    protected function defineDatabaseMigrations()
    {

        $appMigrationPath = __DIR__ . '/../database/migrations';
        $testMigrationPath = __DIR__ . '/../tests/Migrations';

        $this->loadMigrationsFrom($appMigrationPath);

        artisan($this, 'migrate', ['--database' => 'testing']);

        $this->loadMigrationsFrom($testMigrationPath);

        artisan($this, 'migrate', ['--database' => 'testing']);

        $this->beforeApplicationDestroyed(
            fn () => artisan($this, 'migrate:rollback', ['--database' => 'testing'])
        );
    }
}
