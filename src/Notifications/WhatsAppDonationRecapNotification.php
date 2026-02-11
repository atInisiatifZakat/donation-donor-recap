<?php

declare(strict_types=1);

namespace Inisiatif\DonationRecap\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Inisiatif\DonationRecap\Models\Donor;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Inisiatif\WhatsappQontakPhp\Message\Body;
use Inisiatif\DonationRecap\Models\DonorPhone;
use Inisiatif\WhatsappQontakPhp\Message\Header;
use Inisiatif\WhatsappQontakPhp\Message\Message;
use Inisiatif\DonationRecap\Models\DonationRecap;
use Inisiatif\WhatsappQontakPhp\Message\Language;
use Inisiatif\WhatsappQontakPhp\Message\Receiver;
use Inisiatif\DonationRecap\DonationRecap as Recap;
use Inisiatif\WhatsappQontakPhp\Illuminate\Envelope;
use Inisiatif\DonationRecap\Models\DonationRecapDonor;
use Inisiatif\WhatsappQontakPhp\Illuminate\QontakChannel;
use Inisiatif\WhatsappQontakPhp\Illuminate\QontakShouldDelay;
use Inisiatif\WhatsappQontakPhp\Illuminate\QontakNotification;

final class WhatsAppDonationRecapNotification extends Notification implements QontakNotification, QontakShouldDelay, ShouldQueue
{
    use InteractsWithQueue;
    use Queueable;

    public int $tries = 1;

    public function __construct(
        private readonly DonationRecap $donationRecap,
        private readonly DonationRecapDonor $donationRecapDonor
    ) {}

    public function via(): array
    {
        return [QontakChannel::class];
    }

    public function toQontak($notifiable): Envelope
    {
        $phone = $this->getPhoneNumber();
        $name = $this->donationRecapDonor->getAttribute('donor_name');
        $period = $this->donationRecap->getPeriodInString();

        /** @var string $fileUrl */
        $fileUrl = $this->donationRecapDonor->getResultFileUrl();

        $receiver = new Receiver($phone, $name);

        $header = new Header('DOCUMENT', $fileUrl, 'REKAP-ZISWAF.pdf');

        $body = [new Body($name), new Body($name)];

        $message = new Message($receiver, new Language('id'), $body, $header);

        return new Envelope(Recap::getWhatsAppTemplateId(), Recap::getWhatsAppChannelId(), $message);
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

    public function getReleaseDelay(): int
    {
        return 5;
    }
}
