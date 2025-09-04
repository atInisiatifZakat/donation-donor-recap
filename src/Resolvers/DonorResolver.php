<?php

declare(strict_types=1);

namespace Inisiatif\DonationRecap\Resolvers;

use Illuminate\Database\Eloquent\Model;
use Inisiatif\DonationRecap\DonationRecap;
use Inisiatif\DonationRecap\DataTransfers\DonorData;
use Inisiatif\DonationRecap\Exceptions\CannotResolveDonor;

final class DonorResolver implements Contract\DonorResolver
{
    private static ?\Closure $resolveUsing = null;

    public function resolve(string $id): DonorData
    {
        $resolveDonor = self::$resolveUsing ?? static function (string $id): ?Model {
            /** @var class-string<Model> $donorClass */
            $donorClass = DonationRecap::getDonorClassModel();

            /** @var Model|null */
            return $donorClass::query()->whereNull('merge_donor_id')->find($id);
        };

        $donor = $resolveDonor($id);

        if (! $donor instanceof Model) {
            throw CannotResolveDonor::make($id);
        }

        return DonorData::from([
            'donorId' => $donor->getKey(),
            'donorName' => $donor->getAttribute('name'),
            'donorIdentificationNumber' => $donor->getAttribute('identification_number'),
            'donorPhoneNumber' => $donor->getAttribute('phone')?->getAttribute('number') ?? null,
            'donorTaxNumber' => $donor->getAttribute('tax')?->getAttribute('tax_number') ?? null,
            'donorAddress' => $donor->getAttribute('address'),
        ]);
    }

    public function resolveDonorUsing(\Closure $callback): void
    {
        self::$resolveUsing = $callback;
    }
}
