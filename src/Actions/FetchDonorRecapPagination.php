<?php

declare(strict_types=1);

namespace Inisiatif\DonationRecap\Actions;

use Carbon\CarbonImmutable;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Inisiatif\DonationRecap\Models\DonationRecapDonor;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

final class FetchDonorRecapPagination
{
    public function handle(string $donorId, Request $request): LengthAwarePaginator
    {
        $builder = DonationRecapDonor::query()->with([
            'recap', 'recap.template' => fn (Relation $relation) => $relation->select(['id', 'name']),
        ])->where('donor_id', $donorId);

        return QueryBuilder::for($builder, $request)->allowedFilters([
            AllowedFilter::exact('state', 'recap.state'),
            AllowedFilter::exact('template', 'recap.template_id'),
            AllowedFilter::callback('start', static function (Builder $query, $value, string $property): Builder {
                $date = CarbonImmutable::parse($value);

                return $query->where($property, '>=', $date->startOfDay());
            }, 'recap.start_at'),
            AllowedFilter::callback('end', static function (Builder $query, $value, string $property): Builder {
                $date = CarbonImmutable::parse($value);

                return $query->where($property, '<=', $date->endOfDay());
            }, 'recap.end_at'),
            AllowedFilter::callback('created', static function (Builder $query, $value, string $property): Builder {
                $date = CarbonImmutable::parse($value);

                return $query->whereBetween($property, [$date->startOfDay(), $date->endOfDay()]);
            }, 'created_at'),
        ])->paginate()->appends($request->all());
    }
}
