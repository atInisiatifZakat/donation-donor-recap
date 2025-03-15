<?php

declare(strict_types=1);

namespace Inisiatif\DonationRecap\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Bus;
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

    private const BATCH_SIZE = 100;
    private const DELAY_SECONDS = 2;

    public function __construct(
        private readonly DonationRecap $donationRecap,
    ) {}

    public function handle(): void
    {
        $jobs = [];
        $baseTime = now();
        $batchIndex = 0;

        $this->donationRecap->donors()->each(function (DonationRecapDonor $recapDonor) use (&$jobs, $baseTime, &$batchIndex): void {
            $this->donationRecap->recordHistory('Memproses pengiriman rekap donasi');

            $scheduleTime = $baseTime->copy()->addSeconds($batchIndex * self::DELAY_SECONDS);
            array_push($jobs, (new SendingRecapPerDonor($this->donationRecap, $recapDonor))->delay($scheduleTime));

            if (count($jobs) >= self::BATCH_SIZE) {
                Bus::batch($jobs)->allowFailures(true)->dispatch();
                $jobs = [];
                $batchIndex++;
            }
        });

        // Dispatch the remaining jobs
        if (!empty($jobs)) {
            Bus::batch($jobs)->allowFailures(true)->dispatch();
        }
    }
}
