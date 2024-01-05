<?php

declare(strict_types=1);

namespace Inisiatif\DonationRecap\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Inisiatif\DonationRecap\Models\DonationRecap;
use Inisiatif\DonationRecap\Actions\FetchDonorForRecapPagination;

final class DonorForRecapController
{
    public function index(DonationRecap $recap, Request $request, FetchDonorForRecapPagination $donorForRecap): JsonResource
    {
        return JsonResource::collection(
            $donorForRecap->handle($recap, $request)
        );
    }
}
