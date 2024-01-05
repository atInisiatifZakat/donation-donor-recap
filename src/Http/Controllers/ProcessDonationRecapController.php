<?php

declare(strict_types=1);

namespace Inisiatif\DonationRecap\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Inisiatif\DonationRecap\Models\DonationRecap;
use Inisiatif\DonationRecap\Enums\DonationRecapState;
use Inisiatif\DonationRecap\Jobs\ProcessDonationRecap;

final class ProcessDonationRecapController
{
    public function store(DonationRecap $recap): JsonResponse
    {
        \abort_unless($recap->inState(DonationRecapState::new), 404);

        dispatch(new ProcessDonationRecap($recap));

        return new JsonResponse(null, 204);
    }
}
