<?php

declare(strict_types=1);

namespace Inisiatif\DonationRecap\Jobs;

use Throwable;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Inisiatif\DonationRecap\Models\DonationRecap;
use Inisiatif\DonationRecap\Enums\DonationRecapState;
use Inisiatif\DonationRecap\Enums\ProcessingState;
use Inisiatif\DonationRecap\Models\DonationRecapDonor;

final class IncreaseProgressDonationRecap implements ShouldBeUnique, ShouldQueue
{
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function __construct(
        public readonly DonationRecap $donationRecap,
        public readonly DonationRecapDonor $donor,
    ) {}

    public function handle(): void
    {
        if ($this->donor->inState(ProcessingState::combined)) {
            $this->donationRecap->recordHistory(
                'Update progress pembuatan rekap donasi',
                $this->donor->getAttribute('donor_id')
            );

            DonationRecap::query()
                ->where('id', $this->donationRecap->getKey())
                ->increment('count_progress');
        }
    }

    public function uniqueId(): string
    {
        return $this->donationRecap->getKey();
    }

    public function failed(Throwable $exception): void
    {
        $this->donationRecap->state(DonationRecapState::failure);

        \report($exception);
    }
}
