<?php

declare(strict_types=1);

namespace Inisiatif\DonationRecap\Traits;

trait HasTableName
{
    public static function getDonorTable(): ?string
    {
        /** @var string|null */
        return \config('recap.recording.donor_table_name');
    }

    public static function getDonorPhoneTable(): ?string
    {
        /** @var string|null */
        return \config('recap.recording.donor_phone_table_name');
    }

    public static function getBranchTable(): ?string
    {
        /** @var string|null */
        return \config('recap.recording.branch_table_name');
    }

    public static function getPartnerTable(): ?string
    {
        /** @var string|null */
        return \config('recap.recording.partner_table_name');
    }

    public static function getEmployeeTable(): ?string
    {
        /** @var string|null */
        return \config('recap.recording.employee_table_name');
    }

    public static function getUserTableName(): ?string
    {
        /** @var string|null */
        return \config('recap.recording.user_table_name');
    }

    public static function getDonationTable(): ?string
    {
        /** @var string|null */
        return \config('recap.recording.donation_table_name');
    }

    public static function getDonationDetailTable(): ?string
    {
        /** @var string|null */
        return \config('recap.recording.donation_detail_table_name');
    }

    public static function getFundingCategoryTable(): ?string
    {
        /** @var string|null */
        return \config('recap.recording.donation_funding_category_table_name');
    }

    public static function getFundingTypeTable(): ?string
    {
        /** @var string|null */
        return \config('recap.recording.donation_funding_type_table_name');
    }

    public static function getProgramTable(): ?string
    {
        /** @var string|null */
        return \config('recap.recording.donation_program_table_name');
    }
}
