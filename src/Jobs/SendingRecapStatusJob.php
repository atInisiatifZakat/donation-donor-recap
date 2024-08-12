<?php

declare(strict_types=1);

namespace Inisiatif\DonationRecap\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Inisiatif\DonationRecap\Models\Employee;
use Inisiatif\DonationRecap\Models\DonationRecap;
use Inisiatif\DonationRecap\Mail\DonationRecapStatusMail;

final class SendingRecapStatusJob implements ShouldQueue
{
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function __construct(
        private readonly DonationRecap $donationRecap,
    ) {}

    public function handle(): void
    {
        $this->donationRecap->refresh();

        /** @var Employee|null $employee */
        $employee = $this->donationRecap->loadMissing('employee')->getAttribute('employee');

        if (is_null($employee) || !$employee?->haveValidEmail()) {
            return;
        }

        $mailable = new DonationRecapStatusMail(
            $this->donationRecap,
        );

        Mail::to($employee->getEmail())->send($mailable);
    }
}
