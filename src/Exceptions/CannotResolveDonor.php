<?php

declare(strict_types=1);

namespace Inisiatif\DonationRecap\Exceptions;

final class CannotResolveDonor extends \RuntimeException
{
    public static function make(string $id): self
    {
        return new self(
            sprintf('Donor not found with id `%s`', $id)
        );
    }
}
