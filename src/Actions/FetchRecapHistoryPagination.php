<?php

declare(strict_types=1);

namespace Inisiatif\DonationRecap\Actions;

use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use Inisiatif\DonationRecap\Models\DonationRecapHistory;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

final class FetchRecapHistoryPagination
{
    public function handle(Request $request): LengthAwarePaginator
    {
        return QueryBuilder::for(DonationRecapHistory::query(), $request)->allowedFilters([
            AllowedFilter::exact('donor', 'donor_id'),
            AllowedFilter::exact('recap', 'donation_recap_id'),
        ])->latest()->paginate()->appends($request->all());
    }
}
