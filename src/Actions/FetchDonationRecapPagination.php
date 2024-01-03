<?php

declare(strict_types=1);

namespace Inisiatif\DonationRecap\Actions;

use Carbon\CarbonImmutable;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use Illuminate\Database\Eloquent\Builder;
use Inisiatif\DonationRecap\Models\DonationRecap;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

final class FetchDonationRecapPagination
{
    public function handle(Request $request): LengthAwarePaginator
    {
        $builder = DonationRecap::query()->with([
            'template' => fn (Relation $relation) => $relation->select(['id', 'name']),
        ]);

        return QueryBuilder::for($builder, $request)
            ->allowedFilters([
                AllowedFilter::exact('state', 'state'),
                AllowedFilter::exact('template', 'template_id'),
                AllowedFilter::callback('start', static function (Builder $query, $value, string $property): Builder {
                    $date = CarbonImmutable::parse($value);

                    return $query->where($property, '>=', $date->startOfDay());
                }, 'start_at'),
                AllowedFilter::callback('end', static function (Builder $query, $value, string $property): Builder {
                    $date = CarbonImmutable::parse($value);

                    return $query->where($property, '<=', $date->endOfDay());
                }, 'end_at'),
                AllowedFilter::callback('created', static function (Builder $query, $value, string $property): Builder {
                    $date = CarbonImmutable::parse($value);

                    return $query->whereBetween($property, [$date->startOfDay(), $date->endOfDay()]);
                }, 'created_at'),
                AllowedFilter::exact('donor', 'donors.donor_id'),
            ])
            ->paginate()
            ->appends($request->all());
    }
}
