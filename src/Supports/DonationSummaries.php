<?php

declare(strict_types=1);

namespace Inisiatif\DonationRecap\Supports;

use Illuminate\Support\Collection;
use Inisiatif\DonationRecap\Enums\FundingCategory;
use Inisiatif\DonationRecap\Models\DonationRecapDetail;

final class DonationSummaries extends Collection
{
    public function getFormattedAmountSummary(): string
    {
        $amount = (float) $this->sum('donation_amount');

        return $amount ? \number_format($amount) : '-';
    }

    public function getFormattedCategoryAmount(FundingCategory $category): string
    {
        /** @var DonationRecapDetail|null $item */
        $item = $this->where('category_id', $category->value)->first();

        return $item ? \number_format((float) $item->getAttribute('donation_amount')) : '-';
    }

    public function getFormattedZakatAmount(): string
    {
        return $this->getFormattedCategoryAmount(FundingCategory::zakat);
    }

    public function getFormattedInfaqAmount(): string
    {
        return $this->getFormattedCategoryAmount(FundingCategory::infaq);
    }

    public function getFormattedQurbanAmount(): string
    {
        return $this->getFormattedCategoryAmount(FundingCategory::qurban);
    }

    public function getFormattedWakafAmount(): string
    {
        return $this->getFormattedCategoryAmount(FundingCategory::wakaf);
    }
}
