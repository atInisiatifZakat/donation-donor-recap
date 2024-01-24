<?php

declare(strict_types=1);

namespace Inisiatif\DonationRecap\Actions;

use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use Illuminate\Database\Eloquent\Builder;
use Inisiatif\DonationRecap\Models\Donor;
use Inisiatif\DonationRecap\Models\DonationRecap;
use Inisiatif\DonationRecap\DonationRecap as Recap;
use Inisiatif\DonationRecap\Enums\DonationRecapState;
use Inisiatif\DonationRecap\Filters\HasDonationFilter;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Relations\Relation;
use Inisiatif\DonationRecap\Filters\DoesntHaveDonationFilter;

final class FetchDonorForRecapPagination
{
    public function handle(DonationRecap $recap, Request $request): LengthAwarePaginator
    {
        /** @var Donor $donor */
        $donor = app(Recap::getDonorClassModel());

        $builder = $donor->query()->with([
            'branch' => fn (Relation $relation) => $relation->select(['id', 'name']),
            'partner' => fn (Relation $relation) => $relation->select(['id', 'name']),
            'employee' => fn (Relation $relation) => $relation->select(['id', 'name']),
        ]);

        return QueryBuilder::for($builder, $request)->allowedFilters([
            AllowedFilter::exact('id', 'id'),
            AllowedFilter::exact('number', 'identification_number'),
            AllowedFilter::exact('type'),
            AllowedFilter::partial('name'),
            AllowedFilter::partial('email'),
            AllowedFilter::partial('address'),
            AllowedFilter::exact('employee', 'employee_id'),
            AllowedFilter::exact('branch', 'branch_id'),
            AllowedFilter::exact('outlet', 'outlet_id'),
            AllowedFilter::exact('partner', 'partner_id'),
            AllowedFilter::exact('volunteer', 'volunteer_id'),
            AllowedFilter::partial('phone', 'phone.number'),
            AllowedFilter::custom('doesnt-have-donation', new DoesntHaveDonationFilter),
            AllowedFilter::custom('has-donation', new HasDonationFilter),
        ])->when($request->input('q'), function (Builder $builder) use ($request): Builder {
            return $builder->where(static function (Builder $builder) use ($request): Builder {
                $value = \mb_strtolower((string) $request->string('q', ''), 'UTF8');

                $grammar = $builder->getQuery()->getGrammar();

                $name = $grammar->wrap($builder->qualifyColumn('name'));
                $email = $grammar->wrap($builder->qualifyColumn('email'));
                $number = $grammar->wrap($builder->qualifyColumn('identification_number'));

                return $builder->orWhereRaw("LOWER({$name}) LIKE ?", ["%{$value}%"])
                    ->orWhereRaw("LOWER({$email}) LIKE ?", ["%{$value}%"])
                    ->orWhereRaw("LOWER({$number}) LIKE ?", ["%{$value}%"]);
            });
        })->whereDoesntHave('recaps', function (Builder $builder) use ($recap): Builder {
            return $builder->select('donation_recaps.id')
                ->whereNot('state', DonationRecapState::failure)
                ->whereDate('end_at', $recap->getAttribute('end_at'))
                ->whereDate('start_at', $recap->getAttribute('start_at'))
                ->where('template_id', $recap->getAttribute('template_id'));
        })->whereNull('merge_donor_id')->paginate()->appends($request->all());
    }
}
