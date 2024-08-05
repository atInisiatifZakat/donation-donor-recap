<?php

declare(strict_types=1);

namespace Inisiatif\DonationRecap\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;
use Inisiatif\DonationRecap\Enums\DonationRecapState;
use Inisiatif\DonationRecap\Mail\DonationRecapFailedMail;
use Inisiatif\DonationRecap\Mail\DonationRecapSuccessMail;
use Inisiatif\DonationRecap\Models\DonationRecap;
use Inisiatif\DonationRecap\Models\Employee;

final class SendingRecapStatusJob implements ShouldQueue
{
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function __construct(
        private readonly DonationRecap $donationRecap,
    ) {
    }

    public function handle(): void
    {
        $this->donationRecap->refresh();

        /** @var Employee|null $employee */
        $employee = $this->donationRecap->loadMissing('employee')->getAttribute('employee');

        if (is_null($employee) || !$employee?->haveValidEmail()) {
            return;
        }

        if ($this->donationRecap->inState(DonationRecapState::done)) {
            $mailable = new DonationRecapSuccessMail(
                $this->donationRecap,
            );

            Mail::to($employee->getEmail())->send($mailable);
        }

        if ($this->donationRecap->inState(DonationRecapState::failure)) {
            $mailable = new DonationRecapFailedMail(
                $this->donationRecap,
            );

            Mail::to($employee->getEmail())->send($mailable);
        }
    }
}
