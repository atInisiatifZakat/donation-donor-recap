<?php

declare(strict_types=1);

namespace Inisiatif\DonationRecap\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Inisiatif\DonationRecap\DonationRecap;
use Inisiatif\DonationRecap\Jobs\CheckDonationRecapProgress;

final class CheckDonationRecapProgressController
{
    public function store(DonationRecap $recap): JsonResponse
    {
        dispatch(new CheckDonationRecapProgress($recap));

        return new JsonResponse(null, 204);
    }
}
