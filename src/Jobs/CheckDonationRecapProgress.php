<?php

declare(strict_types=1);

namespace Inisiatif\DonationRecap\Jobs;

use Inisiatif\DonationRecap\Models\DonationRecap;
use Inisiatif\DonationRecap\Enums\DonationRecapState;

final class CheckDonationRecapProgress
{
    public function handle(DonationRecap $recap): void
    {
        $recap->refresh();

        $countTotal = $recap->getAttribute('count_total');
        $countProgress = $recap->getAttribute('count_progress');

        if ($countTotal === $countProgress && !$recap->inState(DonationRecapState::done)) {
            $recap->state(DonationRecapState::done);
        }
    }
}
