<?php

declare(strict_types=1);

namespace Inisiatif\DonationRecap\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Resources\Json\JsonResource;
use Inisiatif\DonationRecap\Models\DonationRecap;
use Inisiatif\DonationRecap\DonationRecap as Recap;
use Inisiatif\DonationRecap\Enums\DonationRecapState;
use Inisiatif\DonationRecap\Models\DonationRecapDonor;
use Inisiatif\DonationRecap\Exceptions\CannotAttachDonor;
use Inisiatif\DonationRecap\Actions\AttachDonorDonationRecap;
use Inisiatif\DonationRecap\Actions\DetachDonorDonationRecap;
use Inisiatif\DonationRecap\Actions\FetchDonationDonorRecapPagination;

final class DonationDonorRecapController
{
    public function index(DonationRecap $recap, Request $request, FetchDonationDonorRecapPagination $donorPagination): JsonResource
    {
        return JsonResource::collection(
            $donorPagination->handle($recap, $request)
        );
    }

    public function store(DonationRecap $recap, Request $request, AttachDonorDonationRecap $attachDonor): JsonResponse
    {
        \abort_unless($recap->inState(DonationRecapState::new), 404);

        $request->validate([
            'donor_id' => [
                'required', Rule::exists(Recap::getDonorClassModel(), 'id'),
            ],
        ]);

        try {
            $attachDonor->handle($recap, $request->input('donor_id'));
        } catch (CannotAttachDonor $exception) {
            throw ValidationException::withMessages([
                'donor_id' => [
                    $exception->getMessage(),
                ],
            ]);
        }

        return new JsonResponse(null, 204);
    }

    public function destroy(DonationRecap $recap, DonationRecapDonor $donor, DetachDonorDonationRecap $detachDonor): JsonResponse
    {
        \abort_unless($recap->inState(DonationRecapState::new), 404);

        $detachDonor->handle($recap, $donor);

        return new JsonResponse(null, 204);
    }
}
