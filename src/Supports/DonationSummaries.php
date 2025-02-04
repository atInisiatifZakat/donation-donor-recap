<?php

declare(strict_types=1);

namespace Inisiatif\DonationRecap\Supports;

use Illuminate\Support\Collection;
use Inisiatif\DonationRecap\Enums\FundingCategory;
use Inisiatif\DonationRecap\Models\DonationRecapDetail;

final class DonationSummaries extends Collection
{
    public function getFormattedTotalAmountSummary(): string
    {
        $totalAmount = $this->getSummary($this->toArray());

        return $totalAmount ? \number_format($totalAmount) : '-';
    }

    public function getFormattedCategoryTotalAmount(FundingCategory $category): string
    {
        /** @var DonationRecapDetail|null $item */
        $item = $this->where('category_id', $category->value)->first();

        return $item ? \number_format((float) $item->getTotalAmount()) : '-';
    }

    public function getFormattedZakatTotalAmount(): string
    {
        return $this->getFormattedCategoryTotalAmount(FundingCategory::zakat);
    }

    public function getFormattedInfaqTotalAmount(): string
    {
        return $this->getFormattedCategoryTotalAmount(FundingCategory::infaq);
    }

    public function getFormattedQurbanTotalAmount(): string
    {
        return $this->getFormattedCategoryTotalAmount(FundingCategory::qurban);
    }

    public function getFormattedWakafTotalAmount(): string
    {
        return $this->getFormattedCategoryTotalAmount(FundingCategory::wakaf);
    }

    public function getSummary(array $array): float
    {
        return array_reduce($array, function ($carry, $item) {
            $amount = (float) $item['donation_amount'];
            $currencyRate = (float) $item['currency_rate'];
            return $carry + ($amount * $currencyRate);
        }, 0);
    }
}
