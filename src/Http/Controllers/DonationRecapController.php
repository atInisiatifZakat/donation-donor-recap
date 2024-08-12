<?php

declare(strict_types=1);

namespace Inisiatif\DonationRecap\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Inisiatif\DonationRecap\Models\DonationRecap;
use Inisiatif\DonationRecap\Actions\NewDonationRecap;
use Inisiatif\DonationRecap\DataTransfers\NewDonationRecapData;
use Inisiatif\DonationRecap\Actions\FetchDonationRecapPagination;
use Inisiatif\DonationRecap\Http\Requests\NewDonationRecapRequest;

final class DonationRecapController
{
    public function index(Request $request, FetchDonationRecapPagination $donationRecap): JsonResource
    {
        return JsonResource::collection(
            $donationRecap->handle($request)
        );
    }

    public function store(NewDonationRecapRequest $request, NewDonationRecap $recap): JsonResource
    {
        $user = $request->user();

        $newRecap = $recap->handle(NewDonationRecapData::from([
            ...$request->except(['start_at', 'end_at']),
            'user_id' => $user->getAttribute('id'),
            'start_at' => $request->date('start_at'),
            'end_at' => $request->date('end_at'),
        ]));

        return JsonResource::make(
            $newRecap->loadMissing('template')
        );
    }

    public function show(DonationRecap $recap): JsonResource
    {
        $recap->loadMissing('template');

        return JsonResource::make($recap);
    }
}
