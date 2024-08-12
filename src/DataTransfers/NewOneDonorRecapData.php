<?php

declare(strict_types=1);

namespace Inisiatif\DonationRecap\DataTransfers;

use DateTime;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Date;
use Spatie\LaravelData\Attributes\Validation\Uuid;
use Spatie\LaravelData\Attributes\Validation\Numeric;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Attributes\Validation\IntegerType;

#[MapName(SnakeCaseMapper::class)]
final class NewOneDonorRecapData extends Data
{
    public function __construct(
        #[Required, IntegerType]
        public readonly int $templateId,

        #[Required, Date]
        public readonly DateTime $startAt,

        #[Required, Date]
        public readonly DateTime $endAt,

        #[Required, Uuid]
        public readonly string $donorId,

        #[Required, IntegerType]
        public readonly string $userId,

        #[Required, StringType, Max(100)]
        public readonly string $donorName,

        #[Required, Numeric]
        public readonly string $donorIdentificationNumber,

        public readonly ?string $donorPhoneNumber = null,
        public readonly ?string $donorTaxNumber = null,
        public readonly ?string $donorAddress = null,
    ) {}
}
