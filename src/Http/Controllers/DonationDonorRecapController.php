<?php

declare(strict_types=1);

namespace Inisiatif\DonationRecap\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Inisiatif\DonationRecap\Models\DonationRecap;
use Inisiatif\DonationRecap\Actions\FetchDonorPagination;

final class DonationDonorRecapController
{
    public function index(DonationRecap $recap, Request $request, FetchDonorPagination $donorPagination): JsonResource
    {
        return JsonResource::collection(
            $donorPagination->handle($recap, $request)
        );
    }
}
