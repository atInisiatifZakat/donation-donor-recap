<?php

declare(strict_types=1);

namespace Inisiatif\DonationRecap\Jobs;

use DateTime;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Inisiatif\DonationRecap\Models\Donor;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\RateLimiter;
use Inisiatif\DonationRecap\Models\DonationRecap;
use Inisiatif\DonationRecap\Models\DonationRecapDonor;
use Inisiatif\DonationRecap\Mail\SendDonationRecapMail;
use Inisiatif\DonationRecap\Notifications\SmsDonationRecapNotification;
use Inisiatif\DonationRecap\Notifications\WhatsAppDonationRecapNotification;

final class SendingRecapPerDonor implements ShouldQueue
{
    use Batchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    private const MAX_ATTEMPTS = 45;

    private const DELAY_SECONDS = 2;

    private const RATE_LIMITER_KEY = 'sending-recap';

    public function __construct(
        private readonly DonationRecap $donationRecap,
        private readonly DonationRecapDonor $donationRecapDonor,
    ) {}

    public function handle(): void
    {

        if ($this->isRateLimited()) {
            $this->release(self::DELAY_SECONDS);

            return;
        }

        $this->donationRecapDonor->loadMissing('donor');

        /** @var Donor|null $donor */
        $donor = $this->donationRecapDonor->getRelation('donor');

        // Send email kalo support
        if ($donor?->sendEmailNotification()) {
            $mailable = new SendDonationRecapMail(
                $this->donationRecap,
                $this->donationRecapDonor
            );

            Mail::to($donor->getEmail())->send($mailable);

            $this->donationRecapDonor->touchQuietly('email_sending_at');
        }

        // Send sms kalo support
        if ($donor?->sendSmsNotification()) {
            $donor->notify(new SmsDonationRecapNotification(
                $this->donationRecap,
                $this->donationRecapDonor
            ));

            $this->donationRecapDonor->touchQuietly('sms_sending_at');
        }

        // Send whatsapp kalo support
        if ($donor?->sendWhatsAppNotification()) {
            $donor->notify(new WhatsAppDonationRecapNotification(
                $this->donationRecap,
                $this->donationRecapDonor
            ));

            $this->donationRecapDonor->touchQuietly('whatsapp_sending_at');
        }

        $this->donationRecap->touchQuietly('last_send_at');
    }

    private function isRateLimited(): bool
    {
        if (RateLimiter::tooManyAttempts(self::RATE_LIMITER_KEY, self::MAX_ATTEMPTS)) {
            return true;
        }

        RateLimiter::hit(self::RATE_LIMITER_KEY, self::DELAY_SECONDS);

        return false;
    }

    public function uniqueId(): string
    {
        return 'sending-recap-donor-' . $this->donationRecapDonor->getKey();
    }

    public function retryUntil(): DateTime
    {
        return now()->addMinutes(5);
    }
}
