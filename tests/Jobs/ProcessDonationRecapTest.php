<?php

declare(strict_types=1);

namespace Inisiatif\DonationRecap\Tests\Jobs;

use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Storage;
use Inisiatif\DonationRecap\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inisiatif\DonationRecap\Enums\ProcessingState;
use Inisiatif\DonationRecap\Enums\DonationRecapState;
use Inisiatif\DonationRecap\Jobs\ProcessDonationRecap;
use Inisiatif\DonationRecap\Jobs\CombineDonorRecapFile;
use Inisiatif\DonationRecap\Jobs\GenerateDonorRecapFile;
use Inisiatif\DonationRecap\Jobs\BuildDonationRecapDetail;
use Inisiatif\DonationRecap\Jobs\CheckDonationRecapProgress;
use Inisiatif\DonationRecap\Jobs\IncreaseProgressDonationRecap;
use Inisiatif\DonationRecap\Database\Factories\DonationRecapFactory;
use Inisiatif\DonationRecap\Database\Factories\DonationRecapDonorFactory;

final class ProcessDonationRecapTest extends TestCase
{
    use RefreshDatabase;

    public function test_process_donation_recap_dispatch_sequentially(): void
    {
        Storage::fake();
        Bus::fake();

        $recap = DonationRecapFactory::new()->createOne([
            'start_at' => '2024-01-01',
            'end_at' => '2024-01-31',
            'count_total' => 2,
            'count_progress' => 0,
            'state' => DonationRecapState::new->value,

        ]);

        DonationRecapDonorFactory::new()->times(2)->create([
            'donation_recap_id' => $recap->getKey(),
            'state' => ProcessingState::new->value,
        ]);

        $job = new ProcessDonationRecap($recap);
        $job->handle();

        Bus::assertChained([
            // First Donor Recap
            IncreaseProgressDonationRecap::class,
            BuildDonationRecapDetail::class,
            GenerateDonorRecapFile::class,
            CombineDonorRecapFile::class,
            CheckDonationRecapProgress::class,

            // Second Donor Recap
            IncreaseProgressDonationRecap::class,
            BuildDonationRecapDetail::class,
            GenerateDonorRecapFile::class,
            CombineDonorRecapFile::class,
            CheckDonationRecapProgress::class,
        ]);
    }
}
