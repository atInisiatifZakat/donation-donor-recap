<?php

declare(strict_types=1);

namespace Inisiatif\DonationRecap\Http\Controllers;

use Inisiatif\DonationRecap\DonationRecap;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Resources\Json\JsonResource;
use Inisiatif\DonationRecap\Actions\NewOneDonorRecap;
use Inisiatif\DonationRecap\Exceptions\CannotResolveDonor;
use Inisiatif\DonationRecap\DataTransfers\NewOneDonorRecapData;
use Inisiatif\DonationRecap\Http\Requests\NewOneDonorRecapRequest;

final class OneDonorRecapController
{
    public function store(NewOneDonorRecapRequest $request, NewOneDonorRecap $recap): JsonResource
    {
        try {
            $donorData = DonationRecap::resolveDonor(
                $request->input('donor_id')
            );
            $user = $request->user();

            $donationRecap = $recap->handle(NewOneDonorRecapData::from([
                ...$request->except(['donor_id', 'start_at', 'end_at']),
                ...$donorData->toArray(),
                'employee_id' => $user->getAttribute('employee_id'),
                'start_at' => $request->date('start_at'),
                'end_at' => $request->date('end_at'),
            ]));

            return JsonResource::make($donationRecap);
        } catch (CannotResolveDonor $exception) {
            throw ValidationException::withMessages([
                'donor_id' => [
                    $exception->getMessage(),
                ],
            ]);
        }
    }
}
