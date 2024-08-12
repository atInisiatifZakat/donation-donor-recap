<?php

declare(strict_types=1);

namespace Inisiatif\DonationRecap\Actions;

use Inisiatif\DonationRecap\Models\DonationRecap;
use Inisiatif\DonationRecap\Enums\DonationRecapState;
use Inisiatif\DonationRecap\DataTransfers\NewDonationRecapData;

final class NewDonationRecap
{
    public function handle(NewDonationRecapData $data): DonationRecap
    {
        /** @var DonationRecap */
        return DonationRecap::query()->create([
            ...$data->only('templateId', 'userId', 'startAt', 'endAt')->toArray(),
            'state' => DonationRecapState::new,
            'count_total' => 0,
        ]);
    }
}
