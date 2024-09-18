<?php

declare(strict_types=1);

namespace Inisiatif\DonationRecap\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Inisiatif\DonationRecap\Models\Donor;
use Illuminate\Contracts\Queue\ShouldQueue;
use Inisiatif\DonationRecap\Models\DonationRecap;
use Inisiatif\DonationRecap\Models\DonationRecapDonor;
use Inisiatif\DonationRecap\Mail\SendDonationRecapMail;
use Inisiatif\DonationRecap\Notifications\SmsDonationRecapNotification;
use Inisiatif\DonationRecap\Notifications\WhatsAppDonationRecapNotification;

final class SendingRecapPerDonor implements ShouldQueue
{
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function __construct(
        private readonly DonationRecap $donationRecap,
        private readonly DonationRecapDonor $donationRecapDonor,
    ) {}

    public function handle(): void
    {
        $this->donationRecapDonor->loadMissing('donor');

        /** @var Donor|null $donor */
        $donor = $this->donationRecapDonor->getRelation('donor');

        // Send email kalo support
        if ($donor?->sendEmailNotification()) {
            $mailable = new SendDonationRecapMail(
                $this->donationRecap, $this->donationRecapDonor
            );

            Mail::to($donor->getEmail())->send($mailable);

            $this->donationRecapDonor->touchQuietly('email_sending_at');
        }

        // Send sms kalo support
        if ($donor?->sendSmsNotification()) {
            $donor->notify(new SmsDonationRecapNotification(
                $this->donationRecap, $this->donationRecapDonor
            ));

            $this->donationRecapDonor->touchQuietly('sms_sending_at');
        }

        // Send whatsapp kalo support
        if ($donor?->sendWhatsAppNotification()) {
            $donor->notify(new WhatsAppDonationRecapNotification(
                $this->donationRecap, $this->donationRecapDonor
            ));

            $this->donationRecapDonor->touchQuietly('whatsapp_sending_at');
        }

        $this->donationRecap->touchQuietly('last_send_at');
    }
}
