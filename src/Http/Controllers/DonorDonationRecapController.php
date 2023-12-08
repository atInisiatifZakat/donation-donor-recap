<?php

declare(strict_types=1);

namespace Inisiatif\DonationRecap\Http\Controllers;

use Illuminate\Http\Request;
use Inisiatif\DonationRecap\DonationRecap;
use Illuminate\Http\Resources\Json\JsonResource;
use Inisiatif\DonationRecap\Exceptions\CannotResolveDonor;
use Inisiatif\DonationRecap\Actions\FetchDonorRecapPagination;

final class DonorDonationRecapController
{
    public function index(string $donor, Request $request, FetchDonorRecapPagination $recapPagination): JsonResource
    {
        try {
            $donorData = DonationRecap::resolveDonor($donor);

            return JsonResource::collection(
                $recapPagination->handle($donorData->donorId, $request)
            );
        } catch (CannotResolveDonor $exception) {
            \abort(404, $exception->getMessage());
        }
    }
}
