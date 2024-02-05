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
        \abort_unless($recap->inState(DonationRecapState::done), 404);

        \dispatch(new SendingDonationRecapJob($recap));

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }
}
