<?php

declare(strict_types=1);

namespace Inisiatif\DonationRecap\Actions;

use Illuminate\Support\Facades\DB;
use Inisiatif\DonationRecap\Models\DonationRecap;
use Inisiatif\DonationRecap\Enums\ProcessingState;
use Inisiatif\DonationRecap\Enums\DonationRecapState;
use Inisiatif\DonationRecap\Jobs\ProcessDonationRecap;
use Inisiatif\DonationRecap\DataTransfers\NewOneDonorRecapData;

final class NewOneDonorRecap
{
    public function handle(NewOneDonorRecapData $data): DonationRecap
    {
        /** @var DonationRecap $recap */
        $recap = DB::transaction(static function () use ($data): DonationRecap {
            /** @var DonationRecap $donationRecap */
            $donationRecap = DonationRecap::query()->create([
                ...$data->only('templateId', 'employeeId', 'startAt', 'endAt')->toArray(),
                'count_total' => 1,
                'single' => true,
                'state' => DonationRecapState::new,
            ]);

            $donationRecap->donors()->create([
                ...$data->except('templateId', 'startAt', 'endAt')->toArray(),
                'state' => ProcessingState::new,
            ]);

            return $donationRecap;
        });

        dispatch(new ProcessDonationRecap($recap));

        return $recap;
    }
}
