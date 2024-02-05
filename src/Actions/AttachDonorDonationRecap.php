<?php

declare(strict_types=1);

namespace Inisiatif\DonationRecap\Actions;

use Illuminate\Support\Facades\DB;
use Inisiatif\DonationRecap\Models\DonationRecap;
use Inisiatif\DonationRecap\Resolvers\DonorResolver;
use Inisiatif\DonationRecap\Enums\DonationRecapState;
use Inisiatif\DonationRecap\Models\DonationRecapDonor;
use Inisiatif\DonationRecap\Exceptions\CannotAttachDonor;
use Inisiatif\DonationRecap\Supports\RecapDonorAttachValidation;

final class AttachDonorDonationRecap
{
    public function __construct(
        private readonly DonorResolver $donorResolver
    ) {
    }

    /**
     * @throw CannotAttachDonor
     */
    public function handle(DonationRecap $recap, string $donorId): void
    {
        RecapDonorAttachValidation::validate($recap, $donorId);

        DB::transaction(function () use ($recap, $donorId): void {
            $donorData = $this->donorResolver->resolve($donorId);

            /** @var DonationRecapDonor $donor */
            $donor = $recap->donors()->create([
                ...$donorData->toArray(),
                'state' => DonationRecapState::new,
            ]);

            $donor->recap()->increment('count_total');
        });
    }
}
