<?php

declare(strict_types=1);

namespace Inisiatif\DonationRecap\DataTransfers;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;
use Spatie\LaravelData\Attributes\MapOutputName;

#[MapOutputName(SnakeCaseMapper::class)]
final class DonorData extends Data
{
    public function __construct(
        public readonly string $donorId,
        public readonly string $donorName,
        public readonly string $donorIdentificationNumber,
        public readonly ?string $donorPhoneNumber = null,
        public readonly ?string $donorTaxNumber = null,
        public readonly ?string $donorAddress = null
    ) {
    }
}
