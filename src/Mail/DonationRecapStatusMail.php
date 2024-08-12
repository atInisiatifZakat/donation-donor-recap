<?php

declare(strict_types=1);

namespace Inisiatif\DonationRecap\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Inisiatif\DonationRecap\Models\DonationRecap;
use Inisiatif\DonationRecap\DonationRecap as Recap;
use Inisiatif\DonationRecap\Enums\ProcessingState;

final class DonationRecapStatusMail extends Mailable
{
    public function __construct(
        private readonly DonationRecap $donationRecap,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address(Recap::getMailSenderAddress(), Recap::getMailSenderName()),
            subject: 'Laporan Status Rekapitulasi ZISWAF - ' . $this->donationRecap->getPeriodInString(),
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

        $donors = $this->donationRecap->donors()->get();

        $donorCount = [];
        $donorCount['all'] = $donors->count();
        $donorCount['new'] = $donors->where('state', ProcessingState::new)->count();
        $donorCount['collecting'] = $donors->where('state', ProcessingState::collecting)->count();
        $donorCount['collected'] = $donors->where('state', ProcessingState::collected)->count();
        $donorCount['generating'] = $donors->where('state', ProcessingState::generating)->count();
        $donorCount['generated'] = $donors->where('state', ProcessingState::generated)->count();
        $donorCount['combining'] = $donors->where('state', ProcessingState::combining)->count();
        $donorCount['combined'] = $donors->where('state', ProcessingState::combined)->count();

        $url = \config('app.frontend_url');

        return new Content(
            view: 'recap::mail.status',
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
