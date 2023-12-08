<?php

declare(strict_types=1);

namespace Inisiatif\DonationRecap\Resolvers\Contract;

use Inisiatif\DonationRecap\DataTransfers\DonorData;

interface DonorResolver
{
    public function resolve(string $id): DonorData;

    public function resolveDonorUsing(\Closure $callback): void;
}
