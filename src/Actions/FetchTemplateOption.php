<?php

declare(strict_types=1);

namespace Inisiatif\DonationRecap\Actions;

use Illuminate\Support\Collection;
use Inisiatif\DonationRecap\Models\DonationRecapTemplate;

final class FetchTemplateOption
{
    public function handle(): Collection
    {
        return DonationRecapTemplate::query()->where('is_active', true)->get();
    }
}
