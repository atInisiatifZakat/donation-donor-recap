<?php

declare(strict_types=1);

namespace Inisiatif\DonationRecap\DataTransfers;

use DateTime;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;
use Spatie\LaravelData\Attributes\Validation\Date;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Attributes\Validation\IntegerType;

#[MapName(SnakeCaseMapper::class)]
final class NewDonationRecapData extends Data
{
    public function __construct(
        #[Required, IntegerType]
        public readonly int $templateId,

        #[Required, StringType]
        public readonly string $employeeId,

        #[Required, Date]
        public readonly DateTime $startAt,

        #[Required, Date]
        public readonly DateTime $endAt,
    ) {}
}
