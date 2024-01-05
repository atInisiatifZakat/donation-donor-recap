<?php

declare(strict_types=1);

namespace Inisiatif\DonationRecap\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Inisiatif\DonationRecap\Actions\FetchRecapHistoryPagination;

final class DonationRecapHistoryController
{
    public function index(Request $request, FetchRecapHistoryPagination $history): JsonResource
    {
        return JsonResource::collection(
            $history->handle($request)
        );
    }
}
