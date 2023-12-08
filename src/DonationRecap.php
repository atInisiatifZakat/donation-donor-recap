<?php

declare(strict_types=1);

namespace Inisiatif\DonationRecap;

use Illuminate\Database\Eloquent\Model;
use Inisiatif\DonationRecap\Models\Donor;
use Inisiatif\DonationRecap\Models\Donation;
use Inisiatif\DonationRecap\Traits\HasTableName;
use Inisiatif\DonationRecap\Models\DonationDetail;
use Inisiatif\DonationRecap\Traits\HasQueueConfig;
use Inisiatif\DonationRecap\DataTransfers\DonorData;
use Inisiatif\DonationRecap\Traits\HasPuppeteerConfig;
use Inisiatif\DonationRecap\Traits\HasFileStorageConfig;
use Inisiatif\DonationRecap\Resolvers\Contract\DonorResolver;

final class DonationRecap
{
    use HasFileStorageConfig;
    use HasPuppeteerConfig;
    use HasQueueConfig;
    use HasTableName;

    /**
     * @var class-string<Model>
     */
    private static string $donorModel = Donor::class;

    /**
     * @var class-string<Model>
     */
    private static string $donationModel = Donation::class;

    /**
     * @var class-string<Model>
     */
    private static string $donationDetailModel = DonationDetail::class;

    public static function getDonationClassModel(): string
    {
        return self::$donationModel;
    }

    /**
     * @return class-string<Model>
     */
    public static function getDonorClassModel(): string
    {
        return self::$donorModel;
    }

    /**
     * @return class-string<Model>
     */
    public static function getDonationDetailClassModel(): string
    {
        return self::$donationDetailModel;
    }

    /**
     * @param  class-string<Model>  $donorModel
     */
    public static function useDonorModel(string $donorModel): void
    {
        self::$donorModel = $donorModel;
    }

    /**
     * @param  class-string<Model>  $donationModel
     */
    public static function useDonationModel(string $donationModel): void
    {
        self::$donationModel = $donationModel;
    }

    /**
     * @param  class-string<Model>  $model
     */
    public static function useDonationDetailModel(string $model): void
    {
        self::$donationDetailModel = $model;
    }

    public static function resolveDonorUsing(\Closure $callback): void
    {
        /** @var DonorResolver $resolver */
        $resolver = app(Resolvers\Contract\DonorResolver::class);

        $resolver->resolveDonorUsing($callback);
    }

    public static function resolveDonor(string $id): DonorData
    {
        /** @var DonorResolver $resolver */
        $resolver = app(Resolvers\Contract\DonorResolver::class);

        return $resolver->resolve($id);
    }
}
