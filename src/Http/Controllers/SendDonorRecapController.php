<?php

declare(strict_types=1);

namespace Inisiatif\DonationRecap\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Inisiatif\DonationRecap\DataTransfers\SendDonorRecapData;

use Inisiatif\DonationRecap\Http\Requests\SendDonorRecapRequest;
use Inisiatif\DonationRecap\Jobs\SendingDonorRecapJob;

final class SendDonorRecapController
{
    public function store(SendDonorRecapRequest $request): JsonResponse
    {
        dispatch(new SendingDonorRecapJob(SendDonorRecapData::from($request->input()), $request->user()));

        return response()->json(null, 204);
    }
}
