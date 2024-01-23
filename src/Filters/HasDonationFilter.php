<?php

declare(strict_types=1);

namespace Inisiatif\DonationRecap\Filters;

use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Spatie\QueryBuilder\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Inisiatif\DonationRecap\Enums\DonationStatus;
use Spatie\QueryBuilder\Exceptions\InvalidFilterValue;

/**
 * @template-implements Filter<Model>
 */
final class HasDonationFilter implements Filter
{
    public function __invoke(Builder $query, mixed $value, string $property): void
    {
        try {
            if (\is_array($value) && \count($value) === 2) {
                $query->whereHas('donations', static function (Builder $builder) use ($value): Builder {
                    $startDate = Carbon::parse(
                        Arr::first($value)
                    )->startOfDay();

                    $endDate = Carbon::parse(
                        Arr::last($value)
                    )->endOfDay();

                    return $builder
                        ->select('id')
                        ->where('transaction_status', DonationStatus::verified->value)
                        ->whereBetween('created_at', [$startDate, $endDate]);
                });
            }
        } catch (\Throwable $exception) {
            throw InvalidFilterValue::make($value);
        }
    }
}
