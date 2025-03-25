<?php

declare(strict_types=1);

namespace Inisiatif\DonationRecap\Mail;

use Carbon\Carbon;
use Illuminate\Mail\Mailable;
use Illuminate\Foundation\Auth\User;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Inisiatif\DonationRecap\DataTransfers\SendDonorRecapData;

final class SendDonorRecapMail extends Mailable
{
    public function __construct(
        private readonly SendDonorRecapData $data,
        private readonly string $filePath,
        private readonly User $user
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address('no-reply@example.com', 'Donation Recap'),
            subject: 'Download Rekapitulasi Donasi Anda',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'recap::mail.donor-list',
            with: [
                'url' => url('/storage/'.$this->filePath),
                'username' => $this->user->getAttribute('name'),
                'donationRecapId' => $this->data->donationRecapId,
                'templateName' => $this->data->templateName,
                'startAt' => Carbon::parse($this->data->startAt)->translatedFormat('d F Y'),
                'endAt' => Carbon::parse($this->data->endAt)->translatedFormat('d F Y'),
                'donationRecapState' => $this->data->donationRecapState,
                'filter' => [
                    'donorIdentificationNumber' => $this->data->filter->donorIdentificationNumber ?? '-',
                    'donorName' => $this->data->filter->donorName ?? '-',
                    'donorPhone' => $this->data->filter->donorPhone ?? '-',
                ],
            ],
        );
    }
}
