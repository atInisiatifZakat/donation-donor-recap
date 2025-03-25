<?php

declare(strict_types=1);

namespace Inisiatif\DonationRecap\DataTransfers;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;
use Spatie\LaravelData\Attributes\Validation\Nullable;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;

#[MapName(SnakeCaseMapper::class)]
final class SendDonorRecapData extends Data
{
    public function __construct(
        #[Required, StringType]
        public readonly string $donationRecapId,

        #[Required, StringType]
        public readonly string $templateName,

        #[Required, StringType]
        public readonly string $startAt,

        #[Required, StringType]
        public readonly string $endAt,

        #[Required, StringType]
        public readonly string $donationRecapState,

        #[Nullable]
        public readonly FilterAttributes $filter,

        #[Required]
        /** @var DataAttributes[] */
        public readonly array $data
    ) {}
}

#[MapName(SnakeCaseMapper::class)]
final class FilterAttributes extends Data
{
    public function __construct(
        #[Nullable, StringType]
        public readonly ?string $donorIdentificationNumber,

        #[Nullable, StringType]
        public readonly ?string $donorName,

        #[Nullable, StringType]
        public readonly ?string $donorPhone,
    ) {}
}

#[MapName(SnakeCaseMapper::class)]
final class DataAttributes extends Data
{
    public function __construct(
        #[Required, StringType]
        public readonly string $donorIdentificationNumber,

        #[Required, StringType]
        public readonly string $donorName,

        #[Required, StringType]
        public readonly string $branchName,

        #[Required, StringType]
        public readonly string $employeeName,

        #[Required, StringType]
        public readonly string $state,

        #[Required, StringType]
        public readonly string $whatsappSendingAt,

        #[Required, StringType]
        public readonly string $smsSendingAt,

        #[Required, StringType]
        public readonly string $emailSendingAt
    ) {}
}
