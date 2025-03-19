<?php

declare(strict_types=1);

namespace Inisiatif\DonationRecap\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Inisiatif\DonationRecap\Models\DonationRecap;
use Inisiatif\DonationRecap\Models\DonationRecapDonor;

final class SendingDonationRecapJob implements ShouldQueue
{
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function __construct(
        private readonly DonationRecap $donationRecap,
    ) {}

    public function handle(): void
    {
        $this->donationRecap->donors()->each(function (DonationRecapDonor $recapDonor): void {
            $this->donationRecap->recordHistory('Memproses pengiriman rekap donasi');

            \dispatch(new SendingRecapPerDonor($this->donationRecap, $recapDonor));
        });
    }
}
