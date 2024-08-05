<?php

declare(strict_types=1);

namespace Inisiatif\DonationRecap\Tests\Jobs;

use Illuminate\Support\Facades\Mail;
use Inisiatif\DonationRecap\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inisiatif\DonationRecap\Enums\DonationRecapState;
use Inisiatif\DonationRecap\Jobs\SendingRecapStatusJob;
use Inisiatif\DonationRecap\Mail\DonationRecapFailedMail;
use Inisiatif\DonationRecap\Mail\DonationRecapSuccessMail;
use Inisiatif\DonationRecap\Database\Factories\DonationRecapFactory;
use Inisiatif\DonationRecap\Jobs\ProcessDonationRecap;

final class SendingRecapStatusJobTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_send_recap_status_success_to_employee(): void
    {
        Mail::fake();

        $donationRecap = DonationRecapFactory::new()->createOne([
            'state' => DonationRecapState::done
        ]);

        \dispatch_sync(new ProcessDonationRecap($donationRecap));

        Mail::assertSent(DonationRecapSuccessMail::class);
    }

    public function test_can_send_recap_status_failed_to_employee(): void
    {
        Mail::fake();

        $donationRecap = DonationRecapFactory::new()->createOne([
            'state' => DonationRecapState::failure
        ]);

        \dispatch_sync(new ProcessDonationRecap($donationRecap));

        Mail::assertSent(DonationRecapFailedMail::class);
    }
}
