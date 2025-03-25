<?php

declare(strict_types=1);

namespace Inisiatif\DonationRecap\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Auth\User;
use Inisiatif\DonationRecap\DataTransfers\SendDonorRecapData;

use Inisiatif\DonationRecap\Mail\SendDonorRecapMail;

final class SendingDonorRecap implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        private readonly SendDonorRecapData $data,
        private readonly string $filePath,
        private readonly User $user
    ) {}

    public function handle(): void
    {
        $mailable = new SendDonorRecapMail($this->data, $this->filePath, $this->user);
        Mail::to($this->user->getAttribute('email'))->send($mailable);
    }
}