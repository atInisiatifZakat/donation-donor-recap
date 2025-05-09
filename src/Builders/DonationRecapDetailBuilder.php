<?php

declare(strict_types=1);

namespace Inisiatif\DonationRecap\Builders;

use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Inisiatif\DonationRecap\Traits\HasTableName;
use Inisiatif\DonationRecap\Models\DonationRecap;
use Inisiatif\DonationRecap\Enums\DonationRecapState;
use Inisiatif\DonationRecap\Enums\FundingCategory;
use Inisiatif\DonationRecap\Models\DonationRecapDonor;

final class DonationRecapDetailBuilder
{
    use HasTableName;

    /**
     * @psalm-suppress PossiblyNullArgument
     */
    public function buildFor(DonationRecap $recap, DonationRecapDonor $donor): void
    {
        DB::table(self::getDonationDetailTable())
            ->select($this->getSelectStatement())
            ->join(
                self::getDonationTable(),
                self::getDonationTable().'.id',
                '=',
                self::getDonationDetailTable().'.donation_id'
            )
            ->join(
                self::getFundingTypeTable(),
                self::getFundingTypeTable().'.id',
                '=',
                self::getDonationDetailTable().'.funding_type_id'
            )
            ->join(
                self::getFundingCategoryTable(),
                self::getFundingCategoryTable().'.id',
                '=',
                self::getFundingTypeTable().'.funding_category_id'
            )
            ->leftJoin(
                self::getFundingGoodTable(),
                self::getFundingGoodTable().'.id',
                '=',
                self::getDonationDetailTable().'.funding_good_id'
            )
            ->leftJoin(
                self::getProgramTable(),
                self::getProgramTable().'.id',
                '=',
                self::getDonationDetailTable().'.program_id'
            )
            ->where(self::getDonationTable().'.donor_id', $donor->getAttribute('donor_id'))
            ->where(self::getDonationTable().'.transaction_status', 'VERIFIED')
            ->where(self::getFundingCategoryTable() . '.id', '!=', FundingCategory::wakaf->value)
            ->whereNull(self::getDonationDetailTable().'.deleted_at')
            ->whereBetween(self::getDonationTable().'.transaction_date', [
                $recap->getPeriodStartDate()->startOfDay(),
                $recap->getPeriodEndDate()->endOfDay(),
            ])->chunkById(1000, function (Collection $items) use ($recap, $donor): void {
                $attributes = $items->map(static function (object $attribute) use ($recap): array {
                    $data = [
                        ...(array) $attribute,
                        'id' => Str::orderedUuid()->toString(),
                        'donation_funding_type_name' => $attribute->donation_funding_type_public_name ?? $attribute->donation_funding_type_name,
                        'donation_amount' => $attribute->donation_total_amount ?? $attribute->donation_amount,
                        'donation_recap_id' => $recap->getKey(),
                        'created_at' => now()->toDateTimeString(),
                        'updated_at' => now()->toDateTimeString(),
                    ];
                    unset($data['donation_detail_id']);
                    unset($data['donation_funding_type_public_name']);
                    unset($data['donation_total_amount']);

                    return $data;
                })->toArray();

                try {
                    DB::table('donation_recap_details')->insert($attributes);
                } catch (\Throwable $exception) {
                    $recap->state(DonationRecapState::failure);
                    $recap->recordHistory($exception->getMessage(), $donor->getAttribute('donor_id'));
                }
            }, self::getDonationDetailTable().'.id', 'donation_detail_id');
    }

    private function getSelectStatement(): array
    {
        return [
            DB::raw(self::getDonationDetailTable().'.id as donation_detail_id'),
            DB::raw(self::getDonationTable().'.transaction_date as donation_transaction_date'),
            DB::raw(self::getDonationTable().'.identification_number as donation_identification_number'),
            DB::raw(self::getDonationTable().'.type as donation_type'),
            DB::raw(self::getFundingCategoryTable().'.id as donation_funding_category_id'),
            DB::raw(self::getFundingCategoryTable().'.name as donation_funding_category_name'),
            DB::raw(self::getFundingTypeTable().'.name as donation_funding_type_name'),
            DB::raw(self::getFundingTypeTable().'.public_name as donation_funding_type_public_name'),
            DB::raw(self::getProgramTable().'.name as donation_program_name'),
            DB::raw(self::getDonationDetailTable().'.good_name as donation_good_name'),
            DB::raw(self::getDonationDetailTable().'.good_quantity as donation_good_quantity'),
            DB::raw(self::getFundingGoodTable().'.unit as donation_good_unit'),
            DB::raw(self::getDonationDetailTable().'.amount as donation_amount'),
            DB::raw(self::getDonationDetailTable().'.total_amount as donation_total_amount'),
            self::getDonationDetailTable().'.donation_id',
            self::getDonationTable().'.donor_id',
        ];
    }
}
