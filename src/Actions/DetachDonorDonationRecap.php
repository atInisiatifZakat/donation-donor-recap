<?php

declare(strict_types=1);

namespace Inisiatif\DonationRecap\Actions;

use Illuminate\Support\Facades\DB;
use Inisiatif\DonationRecap\Models\DonationRecap;
use Inisiatif\DonationRecap\Models\DonationRecapDonor;

final class DetachDonorDonationRecap
{
    public function handle(DonationRecap $recap, DonationRecapDonor $donor): void
    {
        DB::transaction(static function () use ($recap, $donor): void {
            $recap->donors()
                ->where('id', $donor->getKey())
                ->delete();

            if ($recap->getAttribute('count_total') > 0) {
                $recap->newQuery()
                    ->where('id', $recap->getKey())
                    ->decrement('count_total');
            }
        });
    }
}
