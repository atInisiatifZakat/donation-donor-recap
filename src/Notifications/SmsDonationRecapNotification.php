<?php

declare(strict_types=1);

namespace Inisiatif\DonationRecap\Notifications;

use Ziswapp\Zenziva\Message;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Inisiatif\DonationRecap\Models\Donor;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Inisiatif\DonationRecap\Models\DonorPhone;
use Inisiatif\DonationRecap\Models\DonationRecap;
use Inisiatif\DonationRecap\Models\DonationRecapDonor;
use Ziswapp\Zenziva\Laravel\Notification\ZenzivaChannel;
use Ziswapp\Zenziva\Laravel\Concerns\ZenzivaAwareNotificationInterface;

final class SmsDonationRecapNotification extends Notification implements ShouldQueue, ZenzivaAwareNotificationInterface
{
    use InteractsWithQueue;
    use Queueable;

    public int $tries = 1;

    public function __construct(
        private readonly DonationRecap $donationRecap,
        private readonly DonationRecapDonor $donationRecapDonor
    ) {
    }

    public function via(): array
    {
        return [ZenzivaChannel::class];
    }

    public function toZenziva($notifiable): Message
    {
        return new Message($this->getPhoneNumber(), $this->getTextMessage());
    }

    private function getTextMessage(): string
    {
        $text = \view('recap::sms', [
            'period' => $this->donationRecap->getPeriodInString(),
            'donorName' => $this->donationRecapDonor->getAttribute('donor_name'),
            'shortLink' => $this->donationRecapDonor->getShortUrlResultFile(),
        ])->render();

        return \str_replace('  ', ' ', \trim($text));
    }

    private function getPhoneNumber(): string
    {
        $this->donationRecapDonor->loadMissing('donor');

        /** @var Donor $donor */
        $donor = $this->donationRecapDonor->getRelation('donor');

        /** @var DonorPhone $phone */
        $phone = $donor->getPhone();

        return $phone->getAttribute('number');
    }
}
