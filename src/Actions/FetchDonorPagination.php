<?php

declare(strict_types=1);

namespace Inisiatif\DonationRecap\Actions;

use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use Inisiatif\DonationRecap\Models\DonationRecap;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

final class FetchDonorPagination
{
    public function handle(DonationRecap $donationRecap, Request $request): LengthAwarePaginator
    {
        return QueryBuilder::for($donationRecap->donors(), $request)
            ->allowedFilters([
                AllowedFilter::partial('name', 'donor_name'),
                AllowedFilter::partial('identification_number', 'donor_identification_number'),
                AllowedFilter::partial('phone_number', 'donor_phone_number'),
            ])
            ->paginate()
            ->appends($request->all());
    }
}
