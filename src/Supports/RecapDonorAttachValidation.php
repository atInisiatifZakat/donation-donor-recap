<?php

declare(strict_types=1);

namespace Inisiatif\DonationRecap\Supports;

use Illuminate\Database\Eloquent\Builder;
use Inisiatif\DonationRecap\Models\DonationRecap;
use Inisiatif\DonationRecap\Enums\DonationRecapState;
use Inisiatif\DonationRecap\Exceptions\CannotAttachDonor;

final class RecapDonorAttachValidation
{
    /**
     * @throw CannotAttachDonor
     */
    public static function validate(DonationRecap $recap, string $donorId): void
    {
        $isExists = DonationRecap::query()
            ->select('id')
            ->where('template_id', $recap->getAttribute('template_id'))
            ->whereNot('state', DonationRecapState::failure)
            ->whereDate('start_at', $recap->getAttribute('start_at'))
            ->whereDate('end_at', $recap->getAttribute('end_at'))
            ->whereHas('donors', function (Builder $builder) use ($donorId): Builder {
                return $builder->select('id')->where('donor_id', $donorId);
            })
            ->exists();

        if ($isExists) {
            throw CannotAttachDonor::make($donorId);
        }
    }
}
