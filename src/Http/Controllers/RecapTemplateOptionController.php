<?php

declare(strict_types=1);

namespace Inisiatif\DonationRecap\Http\Controllers;

use Illuminate\Http\Resources\Json\JsonResource;
use Inisiatif\DonationRecap\Actions\FetchTemplateOption;

final class RecapTemplateOptionController
{
    public function index(FetchTemplateOption $templateOption): JsonResource
    {
        return JsonResource::collection(
            $templateOption->handle()
        );
    }
}
