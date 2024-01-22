<?php

declare(strict_types=1);

namespace Inisiatif\DonationRecap\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Inisiatif\DonationRecap\Models\DonationRecap;
use Inisiatif\DonationRecap\Enums\DonationRecapState;
use Inisiatif\DonationRecap\Jobs\SendingDonationRecapJob;

final class SendDonationRecapController
{
    public function store(DonationRecap $recap): JsonResponse
    {
        \abort_unless($recap->inState(DonationRecapState::combined), 400, 'Donation recap is not in combined state.');

        \dispatch(new SendingDonationRecapJob($recap));

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }
}
