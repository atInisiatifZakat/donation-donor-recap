<?php

declare(strict_types=1);

namespace Inisiatif\DonationRecap\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Inisiatif\DonationRecap\Models\DonationRecap;
use Inisiatif\DonationRecap\Actions\FetchDonationRecapPagination;

final class DonationRecapController
{
    public function index(Request $request, FetchDonationRecapPagination $donationRecap): JsonResource
    {
        return JsonResource::collection(
            $donationRecap->handle($request)
        );
    }

    public function show(DonationRecap $recap): JsonResource
    {
        $recap->loadMissing('template');

        return JsonResource::make($recap);
    }
}
