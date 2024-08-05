<?php

declare(strict_types=1);

namespace Inisiatif\DonationRecap\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Inisiatif\DonationRecap\Models\DonationRecap;
use Inisiatif\DonationRecap\DonationRecap as Recap;

final class DonationRecapSuccessMail extends Mailable
{
    public function __construct(
        private readonly DonationRecap $donationRecap,
    ) {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address(Recap::getMailSenderAddress(), Recap::getMailSenderName()),
            subject: 'Laporan Rekapitulasi Berhasil Diproses - ' . $this->donationRecap->getPeriodInString(),
            tags: ['rekapitulasi-donasi'],
            metadata: [
                'recap_id' => $this->donationRecap->getKey(),
            ],
        );
    }

    public function content(): Content
    {
        $employee = $this->donationRecap->loadMissing('employee')->getAttribute('employee');
        $template = $this->donationRecap->loadMissing('template')->getAttribute('template');
        $donorCount = $this->donationRecap->donors()->count();
        $url = \config('app.frontend_url');

        return new Content(
            view: 'recap::mail.success',
            with: [
                'employeeName' => $employee->getAttribute('name'),
                'templateName' => $template->getAttribute('name'),
                'period' => $this->donationRecap->getPeriodInString(),
                'donorCount' => $donorCount,
                'url' => $url
            ],
        );
    }
}
