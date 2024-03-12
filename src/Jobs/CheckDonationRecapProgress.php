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

final class CheckDonationRecapProgress implements ShouldBeUnique, ShouldQueue
{
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function __construct(
        public readonly DonationRecap $donationRecap,
    ) {
    }

    public function handle(): void
    {
        $this->donationRecap->refresh();

        $countTotal = $this->donationRecap->getAttribute('count_total');
        $countProgress = $this->donationRecap->getAttribute('count_progress');

        if ($countTotal === $countProgress && !$this->donationRecap->inState(DonationRecapState::done)) {
            $this->donationRecap->state(DonationRecapState::done);
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
