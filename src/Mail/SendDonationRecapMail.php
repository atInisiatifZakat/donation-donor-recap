<?php

declare(strict_types=1);

namespace Inisiatif\DonationRecap\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Mail\Attachment;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Inisiatif\DonationRecap\Models\DonationRecap;
use Inisiatif\DonationRecap\DonationRecap as Recap;
use Inisiatif\DonationRecap\Models\DonationRecapDonor;

final class SendDonationRecapMail extends Mailable
{
    public function __construct(
        private readonly DonationRecap $donationRecap,
        private readonly DonationRecapDonor $recapDonor,
    ) {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address(Recap::getMailSenderAddress(), Recap::getMailSenderName()),
            subject: 'Laporan Rekapitulasi Transaksi ZISWAF - '.$this->donationRecap->getPeriodInString(),
            tags: ['rekapitulasi-donasi'],
            metadata: [
                'recap_id' => $this->donationRecap->getKey(),
                'recap_donor_id' => $this->recapDonor->getKey(),
            ],
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'recap::mail',
            with: [
                'period' => $this->donationRecap->getPeriodInString(),
                'donorName' => $this->recapDonor->getAttribute('donor_name'),
            ],
        );
    }

    public function attachments(): array
    {
        $fileName = 'Rekapitulasi Transaksi ZISWAF an '.$this->recapDonor->getAttribute('donor_name');

        return [
            Attachment::fromStorageDisk(
                $this->recapDonor->getAttribute('result_disk'),
                $this->recapDonor->getAttribute('result_file_path')
            )->as($fileName)->withMime('application/pdf'),
        ];
    }
}
