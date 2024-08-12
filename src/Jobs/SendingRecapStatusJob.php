<?php

declare(strict_types=1);

namespace Inisiatif\DonationRecap\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Inisiatif\DonationRecap\Models\User;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
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

        /** @var User|null $user */
        $user = $this->donationRecap->loadMissing('user')->getAttribute('user');

        if (is_null($user) || !$user?->haveValidEmail()) {
            return;
        }

        $mailable = new DonationRecapStatusMail(
            $this->donationRecap,
        );

        Mail::to($user->getEmail())->send($mailable);
    }
}
