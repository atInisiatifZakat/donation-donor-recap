<?php

declare(strict_types=1);

namespace Inisiatif\DonationRecap\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Inisiatif\DonationRecap\Models\DonationRecap;
use Inisiatif\DonationRecap\Jobs\ReprocessDonationRecapDonor;
use Inisiatif\DonationRecap\Models\DonationRecapDonor;

final class ReprocessDonationRecapDonorController
{
    public function store(DonationRecap $recap, DonationRecapDonor $donor): JsonResponse
    {
        dispatch(new ReprocessDonationRecapDonor($recap, $donor));

        return new JsonResponse(null, 204);
    }
}
